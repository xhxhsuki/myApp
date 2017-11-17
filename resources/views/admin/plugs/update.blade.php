
<div class="row">
    <div class="col-md-12">
        <div class="box box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">Progress Bars Different Sizes</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <p><code>.progress</code></p>

                <div class="progress" style="width: 100%">
                    <div id="t-bar" class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                        <span class="sr-only"></span>
                    </div>
                </div>
                <p>{{ $name }}</p>
                <button id="t-start" type="button" class="btn btn-block btn-success btn-sm" style="width: 20%">更新数据</button>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col (left) -->
</div>
<!-- Scripts -->
<script>
    var timer_is_on=1;
    $('#t-start').click(function () {
        $.ajax({
            url:'/admin/api/start',
            type:'get',
            async:false,    //或false,是否异步
            timeout:5000,    //超时时间
            dataType:'json',    //返回的数据格式：json/xml/html/script/jsonp/text
            success:function(data){
                console.log(data)
            }
        });
        ass();
    });
    function ass(){
        if(timer_is_on == 1){
            t=setTimeout(function(){ass()},100);
            getdata();
        }else{
            clearTimeout(t);
            timer_is_on=1;
        }

    }
    function getdata() {
        $.ajax({
            url:'/admin/api/progress',
            type:'get',
            async:true,    //或false,是否异步
            data:{},
            timeout:5000,    //超时时间
            dataType:'json',    //返回的数据格式：json/xml/html/script/jsonp/text
            success:function(data){
                if (data){
                    if (data == "0000"){
                        $('#t-bar').animate({width: "100%"});
                        timer_is_on=0;
                    }else {
                        var aaa = data.split(",");
                        var percent = 0;
                        if (aaa[0]){
                            percent = aaa[1]/aaa[0]*100;
                            $('#t-bar').css('width',percent+"%");
                        }
                    }
                }
                console.log(data);
            }
        })
    }
</script>

