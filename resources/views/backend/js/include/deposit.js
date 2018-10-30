function depositbyadmin(deposit_id) {
    var index = layer.open({
        type: 2,
        title: "手动确认存款",
        closeBtn: 0,
        area: ['700px', '600px'], //宽高
        shadeClose: true,
        resize:false,
        content: '/backend/money/verifydepositbyadmin/'+deposit_id
    });

}