<div class="modal fade" id="driversList" tabindex="-1" aria-labelledby="schoolUsersListLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="schoolUsersListLabel">Drivers</h5>
        </div>
        <div class="modal-body">
            <div class="mb-3">
                <input type="hidden" name="order_id" class="orderID">
                <select id="selectDriver" name="select_driver" class="form-control form-select form-select-lg mb-3" aria-label=".form-select-lg example">
                    <option value=""  selected>Please select Driver</option>
                    @foreach ($drivers as $driver)
                    <option value="{{$driver->id}}">{{ucfirst($driver->name)}}</option>
                    @endforeach
                </select>
             
            </div>
        </div>
      </div>
    </div>
</div>
