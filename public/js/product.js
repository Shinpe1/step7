console.log('通ってる！');


// 削除

$(function() {
    $('.btn-danger').on('click', function(event) {

        event.preventDefault();

    var deleteConfirm = confirm('削除してよろしいでしょうか？');

    if(deleteConfirm == true) {

        var clickEle = $(this)
        // 削除ボタンにユーザーIDをカスタムデータとして埋め込んでます。
        var productID = clickEle.attr('data-product-id');

        $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },   
        url: 'delete'+ productID,
        type: 'POST',
        data: {'id': productID ,
               '_method': 'DELETE'} // DELETE リクエストだよ！と教えてあげる。
        })

    .done(function() {
          // 通信が成功した場合、クリックした要素の親要素の <tr> を削除
        clickEle.parents('tr').remove();
        alert('削除成功！');
        })

    .fail(function() {
        console.log('削除失敗！');
        });

    } else {
        (function(e) {
        e.preventDefault()
        alert('キャンセル！');
        });
    };
    });
});

//検索

$(function() {
    $('#search-form').on('submit', function(event) { 
        console.log('通じたよ');

        event.preventDefault();
        
        $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },   
        url: '/products',
        type: 'GET',
        dataType: 'json',
        data: {
            name : $('#product_name').val(),
            company : $('#company_id').val(),
        }
        
        })

    .done(function(response) {

        console.log('検索成功！');

        var $result = $('');

        $result.empty();

        $.each(response.products,function(product){
            var html =`
            <tr>
                <td>${product.products_id }</td>
                <td>${product.img_path }</td>
                <td>${product.product_name }</td>
                <td>${product.price }</td>
                <td>${product.stock }</td>
                <td>${product.company_id }</td>
            </tr>
            `;
            $result.append(html);

        });
    })

    .fail(function() {
        console.log('検索失敗！');
        });
    });
});
