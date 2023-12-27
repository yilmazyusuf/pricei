@php
use App\Utils\Select2Builder;
/* @var Select2Builder $select2Builder */
$sourceMapping = $select2Builder->getSourceMapping();
@endphp

<select class="form-control select2" id="{{ $select2Builder->getId() }}" name="{{ $select2Builder->getName() }}">
    <option></option>

    @foreach($select2Builder->getSource() as $option)

        @php
        $value = $option->{$sourceMapping[\App\Utils\Select2Builder::SOURCE_MAPPING_VALUE]};
        $label= $option->{$sourceMapping[\App\Utils\Select2Builder::SOURCE_MAPPING_LABEL]};
        @endphp

        <option value="{{ $value }}">{{ $label }}</option>

    @endforeach

</select>
