<div class="btn-group btn-group-sm" role="group" aria-label="Actions">
    <a href="{{route('products.detail',[$product->id])}}" class="btn btn-raised btn-raised-secondary" type="button" data-toggle="tooltip" data-placement="top" title="" data-original-title="Fiyatlar, Raporlar">
        <span class="ul-btn__icon"><i class="nav-icon i-Line-Chart"></i></span><span class="ul-btn__text"> İncele</span></a>
    <a class="btn btn-raised btn-raised-secondary destroy" type="button" data-toggle="tooltip" data-placement="top" title="" data-original-title="Sil">
        <i class="far fa-trash-alt"></i>
    </a>

    <button class="btn btn-raised btn-raised-danger destroy ajax_btn d-none" type="button" data-toggle="tooltip" data-placement="top" title="" data-original-title="Sil">
        <i class="far fa-trash-alt"></i> Onayla
    </button>
</div>



