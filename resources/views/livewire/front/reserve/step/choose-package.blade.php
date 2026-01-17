  <div class="">
      <div class="text-center text-ce h-52  bg-base-200 p-5">

          <h1 class="text-4xl text-center font-bold text-base-content">Lets plan your photoplan</h1>

          <p class="text-base-content/60 mt-2">Capture your special moments with us</p>

      </div>


      <div class="card w-full container mx-auto bg-base-100 -mt-6 card-lg">
          <div class="mt-8 flex justify-center">
              @include('livewire.front.reserve.navigation')
          </div>

          <div class="grid grid-cols-1 md:grid-cols-3 gap-9 px-4 py-12  justify-center place-items-center">
              <div class="w-full  bg-gray-300 rounded-xl">
                  <x-mary-card title="{{ $cityName }}" shadow separator class="bg-base shadow-2xl!">
                      <ul>
                          <li>1 Hour Duration</li>

                          <li>50+ Edited Photos</li>

                          <li>20 Downloadable Photos</li>

                      </ul>
                      <x-slot:actions separator class="flex! justify-between! align-middle!">
                          <span class="text-2xl font-extrabold text-primary">

                              {{ number_format($price, 0, ',', '.') }}
                          </span>

                          <x-mary-button label="Select" wire:click="submit" spinner="submit"
                              class="btn-primary btn-sm" />

                      </x-slot:actions>
                  </x-mary-card>
              </div>

          </div>
      </div>
  </div>
