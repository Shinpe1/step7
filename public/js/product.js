console.log('通ってる！');


$(function() {
    $('#deleteTarget').on('click', function() {
    var deleteConfirm = confirm('削除してよろしいでしょうか？');

    if(deleteConfirm == true) {
        var clickEle = $(this)
        // 削除ボタンにユーザーIDをカスタムデータとして埋め込んでます。
        var productID = clickEle.attr('products_id');

        $.ajax({
        url: '/destroy/' +productID,
        type: 'POST',
        dataType: 'json',
        data: {'id': productID ,
                 '_method': 'DELETE'} // DELETE リクエストだよ！と教えてあげる。
        })

    .done(function() {
          // 通信が成功した場合、クリックした要素の親要素の <tr> を削除
        clickEle.parents('tr').remove();
        alert('成功！');
        })

    .fail(function() {
        alert('失敗！');
        });

    } else {
        (function(e) {
        e.preventDefault()
        alert('完了！');
        });
    };
    });
});