@extends('layouts.app')
@section('content')
<div class="container-fluid py-5" style="background-color:#f9fafb;">
    <div class="container">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center rounded-top-4">
                <h4 class="mb-0 fw-semibold">Order Details — #{{ $order->id }}</h4>
                <span class="badge bg-light text-primary text-uppercase">{{ ucfirst($order->status) }}</span>
            </div>

            <div class="card-body p-4">
                @if (Session::has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ Session::get('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('order.updateOrder') }}" method="POST">
                    @csrf
                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                    <input type="hidden" name="customer_id" value="{{ $order->customer->id }}">

                    <div class="row g-4">
                        <!-- Business Info -->
                        <div class="col-12">
                            <h5 class="border-bottom pb-2 text-primary">Customer Information</h5>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Business Name</label>
                            <input readonly type="text" class="form-control shadow-sm" value="{{ $order->customer->business_name }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Delivery Date</label>
                            <input name="date" type="date" class="form-control shadow-sm" value="{{ $order->delivery_date }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Address</label>
                            <input readonly type="text" class="form-control shadow-sm" value="{{ $order->customer->address }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Phone #</label>
                            <input readonly type="text" class="form-control shadow-sm" value="{{ $order->customer->phone_no }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">POC Name</label>
                            <input readonly type="text" class="form-control shadow-sm" value="{{ $order->customer->poc_name }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Email</label>
                            <input readonly type="email" class="form-control shadow-sm" value="{{ $order->customer->email }}">
                        </div>

                        <!-- Order Info -->
                        <div class="col-12 mt-4">
                            <h5 class="border-bottom pb-2 text-primary">Order Information</h5>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Load Type</label>
                            <select name="load_type" class="form-select shadow-sm">
                                <option value="" selected></option>
                                <option value="box_truck_route" {{ $order->load_type == 'box_truck_route' ? 'selected' : '' }}>Box Truck Route</option>
                                <option value="trailer_swap" {{ $order->load_type == 'trailer_swap' ? 'selected' : '' }}>Trailer Swap</option>
                                <option value="state" {{ $order->load_type == 'state' ? 'selected' : '' }}>State</option>
                                <option value="tdf" {{ $order->load_type == 'tdf' ? 'selected' : '' }}>TDF</option>
                                <option value="steel" {{ $order->load_type == 'steel' ? 'selected' : '' }}>Steel</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Driver</label>
                            <select name="driver_id" class="form-select shadow-sm">
                                <option value="">Select Driver</option>
                                @foreach ($drivers as $driver)
                                    <option value="{{ $driver->id }}" {{ $driver->id == $order->driver_id ? 'selected' : '' }}>
                                        {{ ucfirst($driver->name) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Spoke With</label>
                            <input type="text" name="spoke_with" class="form-control shadow-sm">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Estimated Tires</label>
                            <input type="text" name="estimated_tires" class="form-control shadow-sm">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Create Order?</label>
                            <select name="create_order" class="form-select shadow-sm">
                                <option value="createOrder">Yes</option>
                                <option value="skip">No</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Notes</label>
                            <textarea name="notes" class="form-control shadow-sm" rows="2">{{ $order->notes }}</textarea>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center mt-5 gap-3 flex-wrap">
                        <button type="submit" class="btn btn-primary px-4 rounded-pill">💾 Save Changes</button>
                        <button type="reset" class="btn btn-outline-secondary px-4 rounded-pill">Reset</button>
                        <a href="{{ route('order.delete', $order->id) }}" class="btn btn-outline-danger px-4 rounded-pill">🗑 Delete</a>
                        @if($order->status !== 'completed')
                            <button type="button" class="btn btn-success px-4 rounded-pill" data-bs-toggle="modal" data-bs-target="#completeOrderModal">
                                ✅ Mark as Complete
                            </button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Complete Order Modal -->
<div class="modal fade" id="completeOrderModal" tabindex="-1" aria-labelledby="completeOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 shadow">
            <div class="modal-header bg-primary text-white rounded-top-4">
                <h5 class="modal-title fw-semibold">Complete Order</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form id="completeOrderForm" action="{{ route('order.completeOrder') }}" method="POST">
                    @csrf
                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                    <label for="completeOrderNotes" class="form-label fw-semibold">Completion Notes</label>
                    <textarea class="form-control shadow-sm" id="completeOrderNotes" name="complete_order_notes" rows="3" placeholder="Enter notes..." required></textarea>
                </form>
            </div>
            <div class="modal-footer border-0 d-flex justify-content-end gap-2 px-4 pb-4">
                <button type="button" class="btn btn-outline-secondary px-3 rounded-pill" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success px-4 rounded-pill" id="completeOrderButton">Complete Now</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    $(function () {
        $('#completeOrderButton').on('click', function () {
            $('#completeOrderForm').submit();
        });
    });
</script>
@endpush
