<tbody class="border-top" id="item-{{ $id }}">
    <tr data-variant="{{ $variantString }}" data-id="{{ $id }}" class="id-delete-{{ $id }}">
        <td class="border-bottom-0">
            <i class="fa-solid fa-trash row-delete"></i>
        </td>
        <td class="fw-bold border-bottom-0">
            <div class="whitespace-normal mw-600">
                {{ $name }}
            </div>
            <input type="text" name="items[{{ $id }}][id]" value="{{ $id }}" hidden>
            <input type="text" name="items[{{ $id }}][item_id]" value="{{ $id }}" hidden>
            <input type="text" name="items[{{ $id }}][has_variants]" value="{{ $hasVar }}" hidden>
            <input type="text" name="items[{{ $id }}][has_serials]" value="{{ $hasSer }}" hidden>
            <input type="text" name="items[{{ $id }}][name]" value="{{ $name }}" hidden>
            <input type="text" name="items[{{ $id }}][old_quantity]" value="{{ $quantity ?? 0 }}" hidden>
            <input type="number" hidden value="" name="items[{{ $id }}][selected][variations][]" class="form-control">
        </td>
        <td class="border-bottom-0">
            @php
                echo  $trackWeight;
            @endphp
        </td>
        <td class="border-bottom-0"><input type="number" value="{{ $quantity ?? 1 }}" name="items[{{ $id }}][quantity]" class="form-control" required></td>
        <td class="border-bottom-0">
            <select name="items[{{ $id }}][unit_id]" id="" class="form-select form-control">
                @php
                    echo $unitHtml
                @endphp
            </select>
        </td>
    </tr>
</tbody>