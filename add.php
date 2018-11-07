<html>
<head>
    <title>学生信息管理</title>
</head>
<body>
<center>
    <?php 
        require_once __DIR__ . "/config.php";
        include_once __DIR__ . "/menu.php";
    ?>
    <h3>增加学生信息</h3>

    <form id="addstu" name="addstu" method="post" action="action.php?action=add">
        <table>
            <tr>
                <td>姓名</td>
                <td><input id="name" name="name" type="text"/></td>
            </tr>
            <tr>
                <td>学号</td>
                <td><input id="number" name="number" type="number"/></td>
            </tr>
            <tr>
                <td>性别</td>
                <td><input type="radio" name="sex" value="m"/>&nbsp;男
                    <input type="radio" name="sex" value="w"/>&nbsp;女
                </td>
            </tr>
            <tr>
                <td>年龄</td>
                <td><input type="number" name="age" id="age"/></td>
            </tr>
            <tr>
                <td>学院</td>
                <td><input id="cate" name="cate" type="text"/></td>
            </tr>
            <tr>
                <td>班级</td>
                <td><input id="class" name="class" type="text"/></td>
            </tr>
            <tr>
                <td>专业</td>
                <td><input id="major" name="major" type="text"/></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td><input type="submit" value="增加"/>&nbsp;&nbsp;
                    <input type="reset" value="重置"/>
                </td>
            </tr>
        </table>

    </form>
</center>
</body>
</html>

add