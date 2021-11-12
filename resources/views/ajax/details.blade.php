<div class="row removable">
    <div class="col-md-3"></div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="service_id">@lang('Service')</label>
            <select class="form-control input-solid" id="service_id{{ $index }}" name="service_id[{{ $index }}]">
                <option value=""></option>
                @foreach($services as $key => $service)
                    <option value="{{ $key }}">{{ $service }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label for="qty">@lang('Qty')</label>
            <input type="number" class="form-control input-solid" id="qty{{ $index }}" name="qty[{{ $index }}]">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="notes">@lang('Notes')</label>
            <input type="text" class="form-control input-solid" id="notes{{ $index }}" name="notes[{{ $index }}]">
        </div>
    </div>
    <div class="col-md-1 pt-4">
        <label class="btnRmv">
            <span class="info-2">
                <i class="fas fa-trash"></i>
            </span>
        </label>
    </div>
</div>

<script>
    $(function(){
        $("#service_id{{ $index }}").select2({"allowClear":true,"placeholder":{"id":"","text":"Please Select Option"}});

        $(".btnRmv").on("click", function(){
            $(this).closest('div.removable').remove();
        });
    })
</script>
