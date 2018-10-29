function opennewmanhua() {
    var index = layer.open({
        type: 2,
        title: "添加漫画",
        closeBtn: 0,
        area: ['700px', '500px'], //宽高
        shadeClose: true,
        resize:false,
        content: '/backend/manhua/addmanhua/'
    });
}