<tr data-variant="{{ $variantString }}" data-id="{{ $id }}" class="id-delete-{{ $id }}">
    <td class="border-bottom-0">
        <i class="fa-solid fa-trash row-delete"></i>
    </td>
    <td class="border-bottom-0">
        @php
            echo $htmlVariants;
        @endphp
    </td>
    <td class="border-bottom-0">
        @php
            echo $trackWeight;
        @endphp
    </td>
    <td class="border-bottom-0">
        <input type="number" value="{{ $quantity ?? 1 }}" name="items[{{ $id }}][selected][variations][{{ $variantId }}][quantity]" class="form-control" required>
        <input type="number" value="{{ $quantity ?? 0 }}" name="items[{{ $id }}][selected][variations][{{ $variantId }}][old_quantity]" hidden class="form-control" required>
        <input type="number" hidden value="{{ $variantId }}" name="items[{{ $id }}][selected][variations][{{ $variantId }}][variation_id]" class="form-control">
    </td>
    <td class="border-bottom-0">
        <select name="items[{{ $id }}][selected][variations][{{ $variantId }}][unit_id]" id="" class="form-select form-control">
            @php
                echo $unitHtml
            @endphp
        </select>
    </td>
</tr>