poll_chart();

function poll_chart() {
    // DOMを取得
    const $chart = document.querySelector("#chart");

    // $chartが取れてこなかった場合
    if (!$chart) {
        return;
    }

    // キャンバス内のコンテキストを取得
    const ctx = $chart.getContext("2d");

    // datasetでHTMLのdataで始まる値を取得してくる
    const likes = $chart.dataset.likes;
    const dislikes = $chart.dataset.dislikes;

    let data;

    // どちらも０の場合、灰色のチャートを表示する処理
    if (likes == 0 && dislikes == 0) {
        // コードの再利用性を高めるため、値が変わるオブジェクトのみを条件分岐で変更し、その値を渡す
        data = {
            labels: ["まだ投票がありません。"],
            datasets: [
                {
                    data: [1],
                    backgroundColor: ["#9ca3af"],
                },
            ],
        };
    } else {
        data = {
            labels: ["賛成", "反対"],
            datasets: [
                {
                    data: [likes, dislikes],
                    backgroundColor: ["#34d399", "#f87171"],
                },
            ],
        };
    }

    // 取得したコンテキストをchartのクラスに渡す
    new Chart(ctx, {
        type: "pie",
        data: data,
        options: {
            legend: {
                position: "bottom",
                labels: {
                    fontSize: 18,
                },
            },
        },
    });
}
