
// 削除

function del () {
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
};



//検索

$(function() {
    del();
    $('#search-form').on('submit', function(event) { 
        
        event.preventDefault();
        
        $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },   
        url: 'products',
        type: 'GET',
        dataType: 'html',
        data: {
            product_name : $("#product_name").val(),
            company_id : $("#company_id").val(),
            min_price : $("#min_price").val(),
            max_price : $("#max_price").val(),
            min_stock : $("#min_stock").val(),
            max_stock : $("#max_stock").val(),
        }
        
        })

    .done(function(data) {
        
        var $result = $('#search.result');
            $result.empty();

            let newTable =$(data).find("#product_table")
            $("#product_table").html(newTable);
            
            del();
            console.log('検索成功！');

    })

    .fail(function() {
        del();
        console.log('検索失敗！');
        });
    });
});
