<hr>

<div class="row m-0">
    <div class="col-md-3 pr-0 pl-0 mb-2" style="">
        <div class="btn-group btn-group-toggle d-flex" data-toggle="buttons">
            <label class="btn btn-outline-primary w-100">
                <i class="i-Up "></i>
                <input type="radio" name="options" id="option1" autocomplete="off"> Fiyatı Artanlar
            </label>
            <label class="btn btn-outline-primary btn-icon w-100">
                <i class="i-Down "></i>
                <input type="radio" name="options" id="option2" autocomplete="off"> Fiyatı Düşenler
            </label>
        </div>
    </div>
    <div class="col-md-2 mb-2">
        <select class=form-control id=isJobActive>
            <option value="">Fiyat Takip
            <option value=1>Aktif
            <option value=0>Pasif
            <option value=>Tümü
        </select>
    </div>
    <div class="col-md-2 pl-0 mb-2">
        <select class="form-control select2" id=platform_id multiple>
            <option></option>
            @foreach(\App\Models\Platforms::orderBy('name')->get() as $platform)
                <option value="{{$platform->id}}">{{$platform->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2 pl-0">
        <button class="btn btn-raised btn-raised-secondary">Temizle</button>
    </div>

</div>
