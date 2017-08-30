/**
 * Created by HCJ on 2017/8/14.
 */

layui.config({
    base: '../js/'
});

layui.use(['paging', 'form','upload'], function () {
    var $ = layui.jquery,
        paging = layui.paging(),
        layerTips = parent.layer === undefined ? layui.layer : parent.layer, //获取父窗口的layer对象
        layer = layui.layer, //获取当前窗口的layer对象
        form = layui.form();

//定义

        paging.init({
            openWait: true,
            url: 'list', //地址
            elem: '#content', //内容容器
            params: {
                //发送到服务端的参数
            },
            type: 'POST',
            tempElem: '#tpl', //模块容器
            pageConfig: { //分页参数配置
                elem: '#paged', //分页容器
                pageSize: 7 //分页大小
            },
            success: function () { //渲染成功的回调
                //alert('渲染成功');

            },
            fail: function (msg) { //获取数据失败的回调
                //alert('获取数据失败')
            },
            complate: function (msg) { //完成的回调
                //alert('处理完成');
                //重新渲染复选框

                form.render('checkbox');
                form.on('checkbox(allselector)', function (data) {
                    var elem = data.elem;

                    $('#content').children('tr').each(function () {
                        var $that = $(this);
                        //全选或反选
                        $that.children('td').eq(0).children('input[type=checkbox]')[0].checked = elem.checked;
                        form.render('checkbox');
                    });
                });

                //绑定所有编辑按钮事件
                $('#content').children('tr').each(function () {
                    var $that = $(this);
                    $that.children('td:last-child').children('a[data-opt=edit]').on('click', function () {
                        layer.msg($(this).data('name'));
                    });

                });
//绑定所有删除按钮事件
                $('#content').children('tr').each(function () {
                    var $that = $(this);
                    $that.children('td:last-child').children('a[data-opt=del]').on('click', function () {
                        var delID = $(this).data('id');
                        layerTips.open({
                            type:0,
                            title:"删除",
                            content:"确定删除？",
                            btn:['确定','取消'],
                            yes:function () {
                                $.ajax({
                                    type: 'GET',
                                    url: 'del/' + delID,
                                    dataType: 'json',
                                    success: function (result, status, xhr) {
                                        console.log("success");
                                        layerTips.msg(status, {icon: 1, time: 1000});

                                        paging.get({
                                        });
                                    },
                                    error: function (xhr, status, error) {

                                        var json = JSON.parse(xhr.responseText);
                                        layerTips.msg(json.msg.tableName, {icon: 2, time: 1000});
                                    }
                                });
                            },
                            btn2:function (index,layero) {

                            }

                        });
                        /**/

                    });

                });

            }

        });





    //获取所有选择的列
    $('#getSelected').on('click', function () {
        ids = '';
        $('#content').children('tr').each(function () {
            var $that = $(this);
            var $cbx = $that.children('td').eq(0).children('input[type=checkbox]')[0].checked;
            if ($cbx) {
                var n = $that.children('td:last-child').children('a[data-opt=edit]').data('id');
                ids += n + ',';

            }
        });
        ids = ids.substring(0, ids.length - 1);
//选择删除
        if (ids === "") {
            return false;
        }
        layerTips.open({
            type: 0,
            title: "删除",
            content: "确定删除？",
            btn: ['确定', '取消'],
            yes: function (index) {
                $.ajax({
                    type: 'GET',
                    url: 'del?ids=' + ids,
                    dataType: 'json',
                    success: function (result, status, xhr) {
                        console.log("success");
                        layerTips.msg(status, {icon: 1, time: 1000});
                        paging.get({
                        });

                    },
                    error: function (xhr, status, error) {

                        var json = JSON.parse(xhr.responseText);
                        layerTips.msg(json.msg.tableName, {icon: 2, time: 1000});
                    }

                });
                //重新加载
                paging.get({

                });
                layerTips.close(index);
            }
        });



    });


    $('#search').on('click', function () {
        parent.layer.alert('你点击了搜索按钮')
        paging.get({
            name: '123'
        });
    });

    var addBoxIndex = -1;
    $('#add').on('click', function () {
        if (addBoxIndex !== -1)
            return;
        //本表单通过ajax加载 --以模板的形式，当然你也可以直接写在页面上读取
        $.get('add', null, function (form) {
            addBoxIndex = layer.open({
                type: 1,
                title: '添加表单',
                content: form,
                btn: ['保存', '取消'],
                shade: false,
                offset: ['0', '30%'],
                area: ['400px', '620px'],
                scrollbar:false,
                zIndex: 19950924,
                maxmin: true,
                yes: function (index) {
                    //触发表单的提交事件
                    $('form.layui-form').find('button[lay-filter=add]').click();
                },
                full: function (elem) {
                    var win = window.top === window.self ? window : parent.window;
                    $(win).on('resize', function () {
                        var $this = $(this);
                        elem.width($this.width()).height($this.height()).css({
                            top: 0,
                            left: 0
                        });
                        elem.children('div.layui-layer-content').height($this.height() - 95);
                    });
                },
                success: function (layero, index) {


                    //弹出窗口成功后渲染表单
                    var form = layui.form();
                    form.render();
                    layui.upload({
                        url: 'upload'
                        ,method: 'POST' //上传接口的http类型
                        ,success: function(res){
                            if(res.code===200){
                                LAY_demo_upload.src = res.url;
                                imgName=res.imgName;
                                $('.site-demo-upbar').remove();
                                $("#aaa").val(imgName);
                                layerTips.msg(res.msg, {icon: 1, time: 1000});
                            }else{
                                layerTips.msg(res.msg+",请上传不超过1M的图片", {icon: 2, time: 1000});
                            }

                        }
                    });

                    $.ajax({
                        type:'GET',
                        url:'select',
                        success:function (data) {
                            for (var j = 0; j < data.length; j++) {
                                $("#select").append("<option value=\""+data[j].id+"\">"+data[j].name+"</option>");
                                form.render('select');
                            }
                        }
                    });

                    form.on('submit(add)', function (data) {

                        var param = data.field;
                        if (param.img===""){
                            layerTips.msg("请先上传图片", {icon: 2, time: 1000});
                            return false;
                        }
                        $.ajax({
                            type: 'POST',
                            url: 'add',
                            data: param,
                            success: function (result, status, xhr) {
                                console.log("success");
                                layerTips.msg(status, {icon: 1, time: 1000});
                                //重调跳转到数据最新页
                                paging.get({
                                });

                            },
                            error: function (xhr, status, error) {

                                var json = JSON.parse(xhr.responseText);
                                layerTips.msg(json.msg.tableName, {icon: 2, time: 1000});
                            }

                        });
                        //这里可以写ajax方法提交表单
                        return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
                    });



                },
                end: function () {
                    addBoxIndex = -1;
                }
            });
        });
    });

    $('#import').on('click', function () {
        var that = this;
        var index = layer.tips('只想提示地精准些', that, {tips: [1, 'white']});
        $('#layui-layer' + index).children('div.layui-layer-content').css('color', '#000000');
    });
});
