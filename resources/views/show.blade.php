@extends('app')

@section('content')

<section class="max-w-6xl mx-auto px-6 py-12">

    <div class="bg-white rounded-3xl shadow-xl overflow-hidden">

        <div class="p-10">

            <div class="inline-flex px-4 py-2 rounded-full bg-indigo-100 text-indigo-700 font-semibold mb-6">
                Event Detail
            </div>

            <h1 class="text-5xl font-bold mb-6">
                {{ $event->title }}
            </h1>

            <div class="grid md:grid-cols-2 gap-8">

                <div>

                    <h3 class="text-lg font-semibold text-slate-500 mb-2">
                        Deskripsi Event
                    </h3>

                    <p class="text-slate-700 leading-relaxed">
                        {{ $event->description }}
                    </p>

                </div>

                <div class="bg-slate-50 rounded-2xl p-8">

                    <h3 class="text-lg font-semibold mb-4">
                        Informasi Tiket
                    </h3>

                    <div class="space-y-3">

                        <div>
                            <span class="text-slate-500">
                                Harga Tiket
                            </span>

                            <h2 class="text-4xl font-bold text-indigo-600">
                                Rp {{ number_format($event->price,0,',','.') }}
                            </h2>
                        </div>

                    </div>

                    <div class="mt-8">

                        <a
                            href="{{ route('checkout.create',$event->id) }}"
                            class="block text-center bg-indigo-600 hover:bg-indigo-700 transition text-white font-semibold py-4 rounded-xl">

                            Pesan Tiket

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>

@endsection