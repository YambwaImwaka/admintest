@extends('adminmodule::layouts.master')

@section('title', translate('Trips'))

@section('content')
    <!-- Main Content -->
    <div class="main-content">
        <div class="container-fluid">
            <h2 class="fs-22 mb-4">{{ translate('trip') }} #{{ $trip->ref_id }}</h2>

            @include('tripmanagement::admin.trip.partials._details-partials-inline')

            <div class="row g-3">
                <div class="col-lg-8">
                    <div class="row g-3">
                        @if ($trip->driver)
                            <div class="col-sm-6">
                                <div class="card border analytical_data">
                                    <div class="card-body position-relative">
                                        <div class="d-flex align-items-start justify-content-between gap-2 mb-2">
                                            <h6 class="d-flex align-items-center gap-2 text-capitalize">
                                                <i class="bi bi-person-fill-gear"></i>
                                                {{ translate('driver_details') }}
                                            </h6>
                                        </div>

                                        <div class="media align-items-center gap-3">
                                            <div class="avatar avatar-xxl avatar-hover rounded">
                                                <img src="{{ onErrorImage(
                                                    $trip?->driver?->profile_image,
                                                    asset('storage/app/public/driver/profile') . '/' . $trip?->driver?->profile_image,
                                                    asset('public/assets/admin-module/img/avatar/avatar.png'),
                                                    'driver/profile/',
                                                ) }}"
                                                     class="rounded fit-object" alt="">
                                                <h6 class="level text-center">{{ $trip->driver->level?->name }}</h6>
                                            </div>
                                            <div class="media-body">
                                                <div class="d-flex flex-column align-items-start gap-1">
                                                    <h6>{{ $trip->driver?->first_name . ' ' . $trip->driver?->last_name }}
                                                    </h6>
                                                    <div
                                                        class="badge bg-primary">{{ $trip->driver->level?->name }}</div>
                                                    <a href="tel:{{ $trip->driver->phone }}">{{ $trip->driver->phone }}</a>
                                                    <a
                                                        href="mailto:{{ $trip->driver->email }}">{{ $trip->driver->email }}</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @elseif ($trip->current_status == 'cancelled')
                            <div class="col-sm-6">
                                <div class="card border analytical_data h-100">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center justify-content-center gap-2 h-100">
                                            <div
                                                class="d-flex flex-column align-items-center justify-content-center gap-2">
                                                <img src="{{ asset('public/assets/admin-module/img/svg/driver.svg') }}"
                                                     class="" alt="" width="50">
                                                <h6 class="text-muted fs-12">
                                                    {{ translate('trip_was_cancel_before_driver_accepted') }}
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="col-sm-6">
                            <div class="card border analytical_data">
                                <div class="card-body position-relative">
                                    <div class="d-flex align-items-start justify-content-between gap-2 mb-2">
                                        <h6 class="d-flex align-items-center gap-2 text-capitalize">
                                            <i class="bi bi-person-fill-gear"></i>
                                            {{ translate('customer_details') }}
                                        </h6>
                                    </div>

                                    <div class="media align-items-center gap-3">
                                        <div class="avatar avatar-xxl avatar-hover rounded">
                                            <img src="{{ onErrorImage(
                                                $trip?->customer?->profile_image,
                                                asset('storage/app/public/customer/profile') . '/' . $trip?->customer?->profile_image,
                                                asset('public/assets/admin-module/img/avatar/avatar.png'),
                                                'customer/profile/',
                                            ) }}"
                                                 class="rounded fit-object" alt="">
                                            <h6 class="level text-center">{{ $trip->customer->level?->name }}</h6>
                                        </div>
                                        <div class="media-body">
                                            <div class="d-flex flex-column align-items-start gap-1">
                                                <h6>{{ $trip->customer?->first_name . ' ' . $trip->customer?->last_name }}
                                                </h6>
                                                <div class="badge bg-primary">{{ $trip->customer->level?->name }}</div>
                                                <a
                                                    href="tel:{{ $trip->customer?->phone }}">{{ $trip->customer?->phone }}</a>
                                                <a
                                                    href="mailto:{{ $trip->customer?->email }}">{{ $trip->customer?->email }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- RIDER NOT FOUND --}}
                        @if (is_null($trip->driver) && $trip->current_status == PENDING)
                            <div class="col-sm-6">
                                <div class="card border analytical_data h-100">
                                    <div class="card-body position-relative">
                                        <div class="d-flex flex-column align-items-center gap-4">
                                            <h6 class="text-muted text-capitalize">{{ translate('rider_not_found') }}
                                            </h6>
                                            <img width="62"
                                                 src="{{ asset('public/assets/admin-module/img/media/rider-not-found.png') }}"
                                                 loading="lazy" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        {{-- END RIDER NOT FOUND --}}
                        @if($trip->trip_cancellation_reason)
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex gap-1">
                                            <div>
                                                <img
                                                    src="{{asset('public/assets/admin-module/img/cancellation_reason.png')}}"
                                                    alt="" width="20" height="20">
                                            </div>
                                            <div>
                                                <h6 class="text-capitalize mb-1">
                                                    {{translate('cancellation_reason')}}
                                                </h6>
                                                <div class="fs-12 ml-4">{{$trip->trip_cancellation_reason}}</div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        @endif


                        {{-- TRIP SUMMARY FOR PENDING OR CANCELLED RIDE --}}
                        @if ($trip->current_status == PENDING || $trip->current_status == ACCEPTED || $trip->current_status == ONGOING || $trip->current_status == RETURNING)
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex flex-column flex-sm-row gap-3 justify-content-between mb-30">
                                            <div class="media align-items-center gap-3">
                                                <div class="avatar avatar-xxl rounded-10">
                                                    <img width="48"
                                                         src="{{ onErrorImage(
                                                            $trip?->vehicle_category?->image,
                                                            asset('storage/app/public/vehicle/category') . '/' . $trip?->vehicle_category?->image,
                                                            asset('public/assets/admin-module/img/media/bike.png'),
                                                            'vehicle/category/',
                                                        ) }}"
                                                         alt="">
                                                </div>
                                                <div class="media-body">
                                                    <div class="d-flex flex-column align-items-start gap-1">
                                                        <div class="text-dark">{{ translate('trip') }}
                                                            #{{ $trip->ref_id }}</div>
                                                        <div class="fs-12" dir="ltr">
                                                            {{ date('d F Y, h:i a', strtotime($trip->created_at)) }}</div>
                                                        <h6 class="fs-13 text-capitalize">
                                                            {{ translate('total_estimated_price') }}
                                                            {{ set_currency_symbol($trip->estimated_fare + 0) }}</h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-column gap-1">
                                                <div
                                                    class="d-flex align-items-center justify-content-sm-end gap-3 gap-sm-0">
                                                    <div class="text-capitalize">{{ translate('order_status') }}:
                                                    </div>
                                                    <h6
                                                        class="fs-12 text-info text-sm-end w-100p {{ $trip->current_status == PENDING ? 'text-warning' : 'text-danger' }}">
                                                        {{ translate($trip->current_status) }}</h6>
                                                </div>
                                                <div
                                                    class="d-flex align-items-center justify-content-sm-end gap-3 gap-sm-0">
                                                    <div class=" text-capitalize">{{ translate('trip_type') }}:</div>
                                                    <h6 class="fs-12 w-100p text-sm-end text-capitalize">
                                                        {{ translate($trip->type) }}</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        {{-- END TRIP SUMMARY FOR PENDING OR CANCELLED RIDE --}}

                        @if ($trip->current_status == COMPLETED || $trip->current_status == CANCELLED || $trip->current_status == RETURNED)
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex flex-column flex-sm-row gap-3 justify-content-between mb-30">
                                            <div class="media align-items-center gap-3">
                                                <div class="avatar avatar-xxl rounded-10">

                                                    <img width="48"
                                                         src="{{ onErrorImage(
                                                            $trip?->vehicleCategory?->image,
                                                            asset('storage/app/public/vehicle/category') . '/' . $trip?->vehicleCategory?->image,
                                                            asset('public/assets/admin-module/img/media/bike.png'),
                                                            'vehicle/category/',
                                                        ) }}"
                                                         alt="">
                                                </div>
                                                <div class="media-body">
                                                    <div class="d-flex flex-column align-items-start gap-1">
                                                        <div class="text-dark">{{ translate('trip') }}
                                                            #{{ $trip->ref_id }}</div>
                                                        <div class="fs-12" dir="ltr">
                                                            {{ date('d F Y, h:i a', strtotime($trip->created_at)) }}</div>
                                                        <h6 class="fs-13">{{ translate('total') }}
                                                            {{ set_currency_symbol($trip->paid_fare) }}</h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-column gap-1">
                                                <div
                                                    class="d-flex align-items-center justify-content-sm-end gap-3 gap-sm-0">
                                                    <div class="text-capitalize">{{ translate('order_status') }}:
                                                    </div>
                                                    <h6 class="fs-12 text-info text-sm-end w-100p {{ $trip->current_status == CANCELLED ? 'text-danger' : '' }}">
                                                        {{ translate($trip->current_status) }}</h6>
                                                </div>
                                                <div
                                                    class="d-flex align-items-center justify-content-sm-end gap-3 gap-sm-0">
                                                    <div class="text-capitalize">{{ translate('payment_status') }}:
                                                    </div>
                                                    <h6
                                                        class="fs-12 {{ $trip->payment_status == UNPAID ? 'text-danger' : 'text-primary' }} text-sm-end w-100p">
                                                        {{ translate($trip->payment_status) }}</h6>
                                                </div>
                                                <div
                                                    class="d-flex align-items-center justify-content-sm-end gap-3 gap-sm-0">
                                                    <div class="text-capitalize">{{ translate('trip_type') }}:</div>
                                                    <h6 class="fs-12 w-100p text-sm-end text-capitalize">
                                                        {{ translate($trip->type) }}</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="px-xl-3">
                                            <dl class="data-list gy-2 text-dark">
                                                <dt class="border-bottom pb-2 text-capitalize">
                                                    <strong>{{ translate('trip_summary') }}</strong>
                                                </dt>
                                                <dd class="border-bottom pb-2 m-0">
                                                    <strong>{{ translate('pricing') }}</strong>
                                                </dd>

                                                <dt class="text-capitalize">{{ translate('trip_amount') }}</dt>
                                                <dd class="m-0"> {{ set_currency_symbol($trip->actual_fare) }}</dd>
                                                @if ($trip->type != 'parcel')
                                                    <dt class="ps-custom-4 text-capitalize">
                                                        <div class="d-flex align-items-center gap-2">
                                                            {{ translate('delay_fee') }} <i
                                                                class="bi bi-info-circle-fill text-primary tooltip-icon"
                                                                data-bs-toggle="tooltip"
                                                                data-bs-title="{{ translate('the_Fee_(per_min)_charged_from_the_customer_when_the_trip_took_longer_than_the_estimated_time') }}"></i>
                                                        </div>
                                                    </dt>
                                                    <dd class="m-0">
                                                        + {{ set_currency_symbol($trip?->fee?->delay_fee) }}</dd>

                                                    <dt class="ps-custom-4">
                                                        <div class="d-flex align-items-center gap-2 text-capitalize">
                                                            {{ translate('idle_fee') }} <i
                                                                class="bi bi-info-circle-fill text-primary tooltip-icon"
                                                                data-bs-toggle="tooltip"
                                                                data-bs-title="{{ translate('the_Fee_(per_min)_charged_from_the_customer_for_make_the_driver_waiting_on_the_ongoing_trip') }}"></i>
                                                        </div>
                                                    </dt>
                                                    <dd class="m-0">
                                                        + {{ set_currency_symbol($trip?->fee?->idle_fee) }}</dd>

                                                    <dt class="ps-custom-4">
                                                        <div class="d-flex align-items-center gap-2 text-capitalize">
                                                            {{ translate('cancellation_fee') }} <i
                                                                class="bi bi-info-circle-fill text-primary tooltip-icon"
                                                                data-bs-toggle="tooltip"
                                                                data-bs-title="{{ translate('the_Fee(in_percentage)_charged_from_the_customer_to_cancel_the_trip') }}"></i>
                                                        </div>
                                                    </dt>
                                                    <dd class="m-0">
                                                        + {{ set_currency_symbol($trip?->fee?->cancellation_fee) }}</dd>
                                                @endif
                                                @if ($trip->type == 'parcel' && $trip->current_status == RETURNED && $trip->fee?->cancelled_by == CUSTOMER)

                                                    <dt class="ps-custom-4">
                                                        <div class="d-flex align-items-center gap-2 text-capitalize">
                                                            {{ translate('return_fee') }} <i
                                                                class="bi bi-info-circle-fill text-primary tooltip-icon"
                                                                data-bs-toggle="tooltip"
                                                                data-bs-title="{{ translate('the_Fee(in_percentage)_charged_from_the_customer_to_cancel_the_trip') }}"></i>
                                                        </div>
                                                    </dt>
                                                    <dd class="m-0">
                                                        + {{ set_currency_symbol($trip?->return_fee) }}</dd>
                                                @endif

                                                <dt class="text-capitalize">{{ translate('discount_amount') }}
                                                    <i
                                                        class="bi bi-info-circle-fill text-primary tooltip-icon"
                                                        data-bs-toggle="tooltip"
                                                        data-bs-title="{{ translate('This amount have got the customer as discount auto during this trip') }}"></i>
                                                </dt>
                                                <dd class="m-0">
                                                    -{{ set_currency_symbol($trip->discount_amount + 0) }}</dd>
                                                <dt class="text-capitalize">
                                                    {{ translate('coupon_discount') }}
                                                    <i
                                                        class="bi bi-info-circle-fill text-primary tooltip-icon"
                                                        data-bs-toggle="tooltip"
                                                        data-bs-title="{{ translate('This amount have got the customer as discount after applying the coupon during this trip') }}"></i>
                                                </dt>
                                                <dd class="m-0">
                                                    -{{ set_currency_symbol($trip->coupon_amount + 0) }}</dd>

                                                    <?php
                                                    $totalAmount = $trip->actual_fare + ($trip?->fee?->delay_fee ?? 0) + ($trip?->fee?->idle_fee ?? 0) + ($trip?->fee?->cancellation_fee ?? 0) - ($trip->coupon_amount ?? 0) - ($trip->discount_amount ?? 0);
                                                    ?>

                                                <dt>
                                                    {{ translate('VAT/Tax') }}
                                                    <small
                                                        class="font-semi-bold"><strong>({{ round((($trip?->fee?->vat_tax ?? 0) * 100) / ( $totalAmount == 0 ? 1: $totalAmount)) }}
                                                            %)</strong></small>
                                                </dt>
                                                <dd class="m-0">
                                                    + {{ set_currency_symbol($trip?->fee?->vat_tax + 0) }}</dd>

                                                @if ($trip->tips > 0)
                                                    <dt>
                                                        {{ translate('tips') }}
                                                        <i
                                                            class="bi bi-info-circle-fill text-primary tooltip-icon"
                                                            data-bs-toggle="tooltip"
                                                            data-bs-title="{{ translate('This amount have got the driver from the customer as reward for his trip complete.') }}"></i>
                                                    </dt>
                                                    <dd class="m-0">+ {{ set_currency_symbol($trip->tips + 0) }}</dd>
                                                @endif

                                                <dt><strong>{{ translate('total') }}</strong></dt>
                                                <dd class="m-0">
                                                    <strong>{{ set_currency_symbol($trip->paid_fare) }}</strong>
                                                </dd>
                                            </dl>
                                        </div>
                                        <div class="mt-4 d-flex justify-content-end gap-3">
                                            <a target="_blank"
                                               href="{{ route('admin.trip.invoice', [$trip->id]) }}?file=print"
                                               class="btn-link text-primary text-capitalize">
                                                <i class="bi bi-file-earmark-arrow-down"></i>
                                                {{ translate('print') }}
                                            </a>

                                            <a target="_blank"
                                               href="{{ route('admin.trip.invoice', [$trip->id]) }}?file=pdf"
                                               class="btn-link text-primary text-capitalize">
                                                <i class="bi bi-file-earmark-arrow-down"></i>
                                                {{ translate('invoice_download') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                @include('tripmanagement::admin.trip.partials._trip-details-status')
            </div>
        </div>
    </div>
    <!-- End Main Content -->
@endsection
