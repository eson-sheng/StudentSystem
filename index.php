<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <title>学生信息管理</title>
    <script>
        function doDel(id) {
            if (confirm("确定要删除么？")) {
                window.location = 'action.php?action=del&id='+id;
            }
        }
    </script>
</head>
<body>
<center>
    <?php
        require_once __DIR__ . "/config.php";
        include_once __DIR__ . "/menu.php";
    ?>
    <h3>浏览学生信息</h3>
    <table width="600" border="1">
        <tr>
            <th>姓名</th>
            <th>学号</th>
            <th>性别</th>
            <th>年龄</th>
            <th>学院</th>
            <th>班级</th>
            <th>专业</th>
            <th>操作</th>
        </tr>
        <?php
        //1.连接数据库
        try {
            $pdo = new PDO("mysql:host=localhost;dbname=school;", "root", MYSQLPASSWORD);
        } catch (PDOException $e) {
            die("数据库连接失败" . $e->getMessage());
        }
        //2.解决中文乱码问题
        $pdo->query("SET NAMES 'UTF8'");
        //3.执行sql语句，并实现解析和遍历
        $sql = "SELECT * FROM stu ";
        foreach ($pdo->query($sql) as $row) {
            echo "<tr>";
            echo "<td>{$row['name']}</td>";
            echo "<td>{$row['number']}</td>";
            $sex = $row['sex'] == 'w' ?  '女' : '男';
            echo "<td>{$sex}</td>";
            echo "<td>{$row['age']}</td>";
            echo "<td>{$row['cate']}</td>";
            echo "<td>{$row['class']}</td>";
            echo "<td>{$row['major']}</td>";
            echo "<td>
                    <a href='javascript:doDel({$row['id']})'>删除</a>
                    <a href='edit.php?id=({$row['id']})'>修改</a>
                  </td>";
            echo "</tr>";
        }

        ?>

    </table>
</center>

</body>
</html>

index