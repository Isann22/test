<x-layouts.app>
    <div class="hero container bg-base h-1/2 p-10 mt-10">
        <div class="hero-content flex-col lg:flex-row-reverse">
            <img src="{{ asset('images/pexels-gabriel-peter-219375-707018.jpg') }}"
                class="max-w-sm rounded-lg shadow-2xl" />
            <div>
                <h1 class="text-5xl font-bold">Get paid for your photography passion </h1>
                <p class="py-6 text-base-content/70">
                    Join thousands of SweetEscape photographers and start getting clients, for any kind of photography.
                </p>
                <button class="btn btn-neutral">Join as a Photographer</button>
            </div>
        </div>
    </div>

    <section class="pt-20 pb-10 bg-base-200">
        <div class="text-center">
            <h1 class="text-neutral font-bold text-4xl">Why <span class="text-base-content/70">Join Us?</span></h1>
        </div>
        <div class="grid grid-cols-4 gap-6 md:grid-cols-8 lg:grid-cols-12">
            <div class="col-span-4">
                <div class="card bg-base">
                    <figure class="px-10 pt-10">
                        <img src="{{ asset('images/Icon clock.png') }}" alt="Shoes" class="rounded-xl" />
                    </figure>
                    <div class="card-body items-center text-center">
                        <h2 class="card-title">Card Title</h2>
                        <p>A card component has a figure, a body part, and inside body there are title and actions
                            parts</p>

                    </div>
                </div>
            </div>
            <div class="col-span-4">
                <div class="card bg-base">
                    <figure class="px-10 pt-10">
                        <img src="{{ asset('images/camera-icon-png--clipart-best-23.png') }}" alt="Shoes"
                            class="rounded-xl w-30" />
                    </figure>
                    <div class="card-body items-center text-center">
                        <h2 class="card-title">Card Title</h2>
                        <p>A card component has a figure, a body part, and inside body there are title and actions
                            parts</p>

                    </div>
                </div>
            </div>
            <div class="col-span-4 ">
                <div class="card bg-base">
                    <figure class="px-10 pt-10">
                        <img src="{{ asset('images/5721997.png') }}" alt="Shoes" class="rounded-xl w-30" />
                    </figure>
                    <div class="card-body items-center text-center">
                        <h2 class="card-title">Card Title</h2>
                        <p>A card component has a figure, a body part, and inside body there are title and actions
                            parts</p>

                    </div>
                </div>
            </div>
        </div>
    </section>

</x-layouts.app>
