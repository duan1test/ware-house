<tbody class="border-top" id="item-{{ $itemId }}">
    <tr>
        <td class="border-bottom-0 pb-0"></td>
        <td class="border-bottom-0 pb-0 fw-bold">
            <div class="whitespace-normal mw-600">
                {{ $name }}
            </div>
            <input type="text" name="items[{{ $itemId }}][item_id]" value="{{ $itemId }}" hidden>
            <input type="text" name="items[{{ $itemId }}][id]" value="{{ $itemId }}" hidden>
            <input type="text" name="items[{{ $itemId }}][has_variants]" value="{{ $hasVar }}" hidden>
            <input type="text" name="items[{{ $itemId }}][has_serials]" value="{{ $hasSer }}" hidden>
            <input type="text" name="items[{{ $itemId }}][name]" value="{{ $name }}" hidden>
            <input type="text" name="items[{{ $itemId }}][old_quantity]" value="{{ $quantity ?? 0 }}" hidden>
            <input type="number" name="items[{{ $itemId }}][quantity]" class="form-control" value="1" hidden>
        </td>
    </tr>
    {{ $htmlVariant }}
</tbody>