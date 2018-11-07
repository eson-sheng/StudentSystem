<html>
<head>
    <title>学生信息管理</title>
</head>
<body>
<center>
    <?php 
        require_once __DIR__ . "/config.php";
        include_once __DIR__ . "/menu.php";

        //1.连接数据库
        try{
            $pdo = new PDO("mysql:host=localhost;dbname=school;","root",MYSQLPASSWORD);
        }catch(PDOException $e){
            die("数据库连接失败".$e->getMessage());
        }
        //2.防止中文乱码
        $pdo->query("SET NAMES 'UTF8'");
        // //3.拼接sql语句，取出信息
        $sql_cate = "SELECT DISTINCT(cate) FROM `stu`";
        $sql_class = "SELECT DISTINCT(class) FROM `stu`";
        $sql_major = "SELECT DISTINCT(major) FROM `stu`";
        
        $stmt_cate = $pdo->query($sql_cate);//返回预处理对象
        $stmt_class = $pdo->query($sql_class);//返回预处理对象
        $stmt_major = $pdo->query($sql_major);//返回预处理对象

        $stu_cate = $stmt_cate->fetchAll(PDO::FETCH_ASSOC);//按照关联数组进行解析
        $stu_class = $stmt_class->fetchAll(PDO::FETCH_ASSOC);//按照关联数组进行解析
        $stu_major = $stmt_major->fetchAll(PDO::FETCH_ASSOC);//按照关联数组进行解析
    ?>
    <h3>查询学生信息</h3>
    <form id="searchstu" name="searchstu" method="post" action="action.php?action=search">
        <table>
            <tr>
                <td colspan="12">请填写搜索条件：</td>
            </tr>
            <tr>
                <td>姓名</td>
                <td><input id="name" name="name" type="text"/></td>
                <td>学号</td>
                <td><input id="number" name="number" type="number"/></td>
                <td>性别</td>
                <td>
                    <select id="sex" name="sex">
                        <option value="">所有</option>
                        <option value="m">男</option>
                        <option value="w">女</option>
                    </select>
                </td>
                <td>年龄</td>
                <td>
                    从
                    <input type="age" name="age_low" id="age_low"/>
                    到
                    <input type="age" name="age_high" id="age_high"/>
                </td>
                <td>学院</td>
                <td>
                    <select id="cate" name="cate">
                        <option value ="all">所有</option>
                        <?php foreach ($stu_cate as $cate): ?>
                            <option value ="<?= $cate['cate']; ?>"><?= $cate['cate']; ?></option>
                        <?php endforeach ?>
                    </select>
                </td>
                <td>班级</td>
                <td>
                    <select id="class" name="class">
                        <option value ="all">所有</option>
                        <?php foreach ($stu_class as $class): ?>
                            <option value ="<?= $class['class']; ?>"><?= $class['class']; ?></option>
                        <?php endforeach ?>
                    </select>
                </td>
                <td>专业</td>
                <td>
                    <select id="major" name="major">
                        <option value ="all">所有</option>
                        <?php foreach ($stu_major as $major): ?>
                            <option value ="<?= $major['major']; ?>"><?= $major['major']; ?></option>
                        <?php endforeach ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>
                    <input type="submit" value="搜索"/ id="search">&nbsp;&nbsp;
                    <input type="reset" value="重置"/>
                </td>
            </tr>
        </table>
    </form>
    <div id="res"></div>
</center>
</body>
<script type="text/javascript">
window.onload=function(){
    document.getElementById('search').onclick = function(event){
        event.preventDefault();
        var xmlhttp,params = [];
        var fromobj = document.getElementById("searchstu");

        var obj = document.querySelectorAll('input,select');

        for (var i = obj.length - 1; i >= 0; i--) {
            params += encodeURIComponent(obj[i].name) + '=' + encodeURIComponent(obj[i].value) + '&';
        }

        // console.log(params);

        // var params = 
        //     "name=" + document.getElementById("name").value + "&" +
        //     "number=" + document.getElementById("number").value + "&" +
        //     "sex=" + document.getElementById("sex").value + "&" +
        //     "age_low=" + document.getElementById("age_low").value + "&" +
        //     "age_high=" + document.getElementById("age_high").value + "&" +
        //     "cate=" + document.getElementById("cate").value + "&" +
        //     "class=" + document.getElementById("class").value + "&" +
        //     "major=" + document.getElementById("major").value;

        //创建xmlhttp对象
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open("POST",fromobj.action,true);
        xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        xmlhttp.send(params);
        xmlhttp.onreadystatechange = function(){
            var data = xmlhttp.responseText;
            document.getElementById('res').innerHTML = "";
            document.getElementById('res').innerHTML = data;
        }
    };

} 
</script>
</html>

search