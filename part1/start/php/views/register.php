<h1>Registerページ</h1>
<!-- 同じURLに対してPOSTメソッドを送る -->
<form action="<?php echo CURRENT_URI; ?>" method="post">
    <div>
        id: <input type="text" name="id" id="">
    </div>
    <div>
        pw: <input type="password" name="pwd" id="">
    </div>
    <div>
        nickname: <input type="text" name="nickname" id="">
    </div>
    <div>
        <input type="submit" value="登録">
    </div>
</form>
