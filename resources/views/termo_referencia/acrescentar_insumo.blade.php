<form onsubmit="savePopover(event, '{{$id}}');" id="container-popover-add-{{$id}}">
    <div class="form-group">
        <textarea class="form-control" is="required" msg=" " style="min-height:100px;" id="motivo-popover-add-{{$id}}" placeholder="Motivo"></textarea>
    </div>
    <div class="input-group">
        <input type="text" class="form-control" placeholder="Qtde." msg=" " is="numeric" id="quantidade-popover-add-{{$id}}"/>
        <span class="input-group-btn">
            <button class="btn btn-primary" type="submit" id="save-popover-add-{{$id}}">
                <i class="fa fa-save"></i>
            </button>
            <button class="btn btn-danger" type="button" id="cancel-popover-add-{{$id}}" onclick="closePopover();">
                <i class="fa fa-close"></i>
            </button>
        </span>
    </div>
</form>