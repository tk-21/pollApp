init();

function init() {
    // DOMとはHTMLをJavascriptで扱うためのオブジェクト
    // $はDOMであることの目印として付けている
    // querySelectorAllで該当するものをすべて取ってくる
    const $inputs = document.querySelectorAll(".validate-target");

    // $inputsから一つずつ$inputを取り出してくる
    // このようにすると、入力欄が増えても一つずつ関数を適用して処理できる
    for (const $input of $inputs) {
        // イベントを検知したときに実行する関数を登録
        // inputの関数の中で値が正しいかどうかを検知する
        $input.addEventListener("input", function (event) {
            // 変更を検知したオブジェクトが格納されている
            const $target = event.currentTarget;

            // 以下でバリデーションチェック
            if ($target.checkValidity()) {
                // checkValidが問題ない場合、is-validのクラスを付与する
                $target.classList.add("is-valid");
                // 合わせてis-invalidのクラスを削除する
                $target.classList.remove("is-invalid");
            } else {
                // falseの場合は逆
                $target.classList.add("is-invalid");
                $target.classList.remove("is-valid");

                // falseの場合、何が問題なのかを判定する
                if ($target.validity.valueMissing) {
                    console.log("値の入力が必須です。");
                } else if ($target.validity.tooShort) {
                    console.log(
                        $target.minLength +
                            "文字以上で入力してください。現在の文字数は" +
                            $target.value.length +
                            "文字です。"
                    );
                } else if ($target.validity.tooLong) {
                    console.log(
                        $target.maxLength +
                            "文字以下で入力してください。現在の文字数は" +
                            $target.value.length +
                            "文字です。"
                    );
                } else if ($target.validity.patternMismatch) {
                    console.log("半角英数字で入力してください。");
                }
            }
        });
    }
}
