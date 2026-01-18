<?php

namespace App\Services;

use App\Enums\PaymentStatus;
use App\Enums\ReservationStatus;
use App\Models\City;
use App\Models\Moment;
use App\Models\Package;
use App\Models\Reservation;
use App\Models\ReservationDetail;
use App\Models\ReservationPayment;
use Illuminate\Support\Facades\DB;

class ReservationService
{
    private const TAX_RATE = 0.12;
    /**
     * Create reservation with Midtrans Snap payment.
     */
    public function createReservation(array $bookingData, string $userId): Reservation
    {
        $this->configureMidtrans();

        return DB::transaction(function () use ($bookingData, $userId) {
            $context = $this->prepareBookingContext($bookingData);
            $reservation = $this->storeReservation($bookingData, $userId, $context);
            $snapToken = $this->generateSnapToken($reservation, $context);
            $this->storePayment($reservation, $snapToken);

            return $reservation->load('payment');
        });
    }

    /**
     * Prepare booking context with package, city, moment and calculated amounts.
     */
    protected function prepareBookingContext(array $bookingData): array
    {
        $package = Package::findOrFail($bookingData['packageId']);
        $city = City::findOrFail($bookingData['cityId']);
        $moment = Moment::findOrFail($bookingData['momentId']);
        
        $price = $this->getPackagePrice($city->id, $package->id);
        $taxAmount = $price * self::TAX_RATE;
        $totalAmount = $price + $taxAmount;

        return [
            'package' => $package,
            'city' => $city,
            'moment' => $moment,
            'price' => $price,
            'taxAmount' => $taxAmount,
            'totalAmount' => $totalAmount,
        ];
    }

    /**
     * Store reservation and its detail.
     */
    protected function storeReservation(array $bookingData, string $userId, array $context): Reservation
    {
        $reservation = Reservation::create([
            'user_id' => $userId,
            'status' => ReservationStatus::Pending,
            'package_price' => $context['price'],
            'tax_rate' => self::TAX_RATE,
            'tax_amount' => $context['taxAmount'],
            'total_amount' => $context['totalAmount'],
        ]);

        ReservationDetail::create([
            'reservation_id' => $reservation->id,
            'city_id' => $context['city']->id,
            'moment_id' => $context['moment']->id,
            'package_id' => $context['package']->id,
            'photoshoot_date' => $bookingData['date'],
            'photoshoot_time' => $bookingData['time'],
            'pax' => $bookingData['pax'],
            'location_type' => $bookingData['location'],
            'location_details' => $bookingData['locationDetails'] ?? null,
            'additional_info' => $bookingData['additionalInfo'] ?? null,
        ]);

        return $reservation;
    }

    /**
     * Store payment record with snap token.
     */
    protected function storePayment(Reservation $reservation, string $snapToken): void
    {
        ReservationPayment::create([
            'reservation_id' => $reservation->id,
            'amount_paid' => $reservation->total_amount,
            'payment_status' => PaymentStatus::Pending,
            'gateway_response' => [
                'snap_token' => $snapToken,
            ],
        ]);
    }

    /**
     * Configure Midtrans SDK.
     */
    protected function configureMidtrans(): void
    {
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        \Midtrans\Config::$isSanitized = config('midtrans.is_sanitized');
        \Midtrans\Config::$is3ds = config('midtrans.is_3ds');
    }

    /**
     * Generate Midtrans Snap token.
     */
    protected function generateSnapToken(Reservation $reservation, array $context): string
    {
        $params = [
            'transaction_details' => [
                'order_id' => $reservation->id,
                'gross_amount' => (int) $reservation->total_amount,
            ],
            'enabled_payments' => [
                'gopay',
                'shopeepay',
                'bca_va',
                'bni_va',
            ],
            'item_details' => $this->buildItemDetails($reservation, $context),
        ];

        $snapResponse = \Midtrans\Snap::createTransaction($params);

        return $snapResponse->token;
    }

    /**
     * Build item details for Midtrans with city and moment names.
     */
    protected function buildItemDetails(Reservation $reservation, array $context): array
    {
        $packageName = $context['package']->name;
        $cityName = $context['city']->name;
        $momentName = $context['moment']->name;

        // Format: "Package Name - City, Moment" (max 50 chars for Midtrans)
        $itemName = substr("{$packageName} - {$cityName}, {$momentName}", 0, 50);

        return [
            [
                'id' => $context['package']->id,
                'price' => (int) $reservation->package_price,
                'quantity' => 1,
                'name' => $itemName,
            ],
            [
                'id' => 'tax',
                'price' => (int) $reservation->tax_amount,
                'quantity' => 1,
                'name' => 'Tax (12%)',
            ],
        ];
    }

    /**
     * Get package price for a specific city from pivot table.
     */
    private function getPackagePrice(string $cityId, string $packageId): float
    {
        $package = Package::where('packages.id', $packageId)
            ->whereHas('cities', fn($q) => $q->where('cities.id', $cityId))
            ->with(['cities' => fn($q) => $q->where('cities.id', $cityId)])
            ->firstOrFail();

        return (float) $package->cities->first()->pivot->price;
    }
}
