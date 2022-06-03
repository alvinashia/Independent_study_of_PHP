<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />
    <title>Document</title>
</head>

<body>
    <select class="form-control" name="area" id="area">
        <option value="" selected disabled>-- 請選擇所在鄉鎮 --</option>
        <option value="頭城鎮" class="selectArea">頭城鎮</option>
        <option value="礁溪鄉" class="selectArea">礁溪鄉</option>
        <option value="員山鄉" class="selectArea">員山鄉</option>
        <option value="宜蘭市" class="selectArea">宜蘭市</option>
        <option value="三星鄉" class="selectArea">三星鄉</option>
        <option value="大同鄉" class="selectArea">大同鄉</option>
        <option value="南澳鄉" class="selectArea">南澳鄉</option>
        <option value="羅東鎮" class="selectArea">羅東鎮</option>
        <option value="冬山鄉" class="selectArea">冬山鄉</option>
        <option value="蘇澳鎮" class="selectArea">蘇澳鎮</option>
        <option value="五結鄉" class="selectArea">五結鄉</option>
        <option value="壯圍鄉" class="selectArea">壯圍鄉</option>

        <!-- TODO:是否能用廻圈判斷？ -->
    </select>
    </div>

    <script>
        const selectArea = document.querySelector('.selectArea')
        if ($row['area'] == option.value) {
            selectArea = selected;
        } else {
            selectArea = '';
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>