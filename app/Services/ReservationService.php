<?php

namespace App\Services;

use App\Enums\PaymentStatus;
use App\Enums\ReservationStatus;
use App\Models\Package;
use App\Models\Reservation;
use App\Models\ReservationDetail;
use App\Models\ReservationPayment;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ReservationService
{
    private const TAX_RATE = 0.12; // 12%

    public function createReservation(array $bookingData, string $userId): Reservation
    {
        // 1. Verify package exists and get server-side price
        $package = Package::findOrFail($bookingData['packageId']);
        
        // 2. Get actual price from city-package pivot (server-side recalculation)
        $actualPrice = $this->getPackagePrice($bookingData['cityId'], $bookingData['packageId']);
        
        // 3. Calculate amounts
        $taxAmount = $actualPrice * self::TAX_RATE;
        $totalAmount = $actualPrice + $taxAmount;

        // 4. Create all records in a transaction
        return DB::transaction(function () use ($bookingData, $userId, $actualPrice, $taxAmount, $totalAmount) {
            // Create reservation
            $reservation = Reservation::create([
                'user_id' => $userId,
                'status' => ReservationStatus::Pending,
                'package_price' => $actualPrice,
                'tax_rate' => self::TAX_RATE,
                'tax_amount' => $taxAmount,
                'total_amount' => $totalAmount,
            ]);

            // Create reservation detail
            ReservationDetail::create([
                'reservation_id' => $reservation->id,
                'city_id' => $bookingData['cityId'],
                'moment_id' => $bookingData['momentId'],
                'package_id' => $bookingData['packageId'],
                'photoshoot_date' => $bookingData['date'],
                'photoshoot_time' => $bookingData['time'],
                'pax' => $bookingData['pax'],
                'location_type' => $bookingData['location'],
                'location_details' => $bookingData['locationDetails'] ?? null,
                'additional_info' => $bookingData['additionalInfo'] ?? null,
            ]);

            // Create payment record (pending status)
            ReservationPayment::create([
                'reservation_id' => $reservation->id,
                'amount_paid' => $totalAmount,
                'status' => PaymentStatus::Pending,
            ]);

            return $reservation;
        });
    }

    /**
     * Get package price for a specific city from pivot table.
     * This ensures we use server-side price, not client-provided.
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
