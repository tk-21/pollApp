init();

function init() {
  // DOMとはHTMLをJavascriptで扱うためのオブジェクト
  // $はDOMであることの目印として付けている
  const $input = document.querySelector(".validate-target");
  // イベントを検知したときに実行する関数を登録
  // inputの関数の中で値が正しいかどうかを検知する
  $input.addEventListener("input", function () {
    alert("値が変更されました");
  });
  console.log($input);
}
