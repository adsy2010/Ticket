<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Log Call</title>
    <link rel="stylesheet" href="templates/css.css">
    <link rel="stylesheet" href="templates/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="templates/bootstrap/css/dashboard.css">
    <script src="templates/scripts/tinymce/js/tinymce/tinymce.min.js"></script>
    <script>  tinyMCE.init({
        mode : "textareas",
        plugins : "spellchecker,insertdatetime,preview",

        menubar:false,
        statusbar: false,
        theme_advanced_toolbar_align : "left"
    });
    </script>
</head>

<body>

<div class="logBox">
    <form action="view.php?view=logTicket&desk={DESK}" method="POST">
        <!-- enctype="multipart/form-data"> -->
    <div class="logBoxSettings">
        <div class="logBoxLeft"><img src="templates/images/{DESKNAME}.png"/></div>
        <div class="logBoxRight">
            <div class="logBoxRightContainer">
                <b>Username: </b>{USERNAME} <br><br>
                <select title="department" name="department" id="department">
                    <option value="0">Department...</option>
                    <option value="1">Art</option>
                    <option value="2">Community</option>
                    <option value="3">Drama</option>
                    <option value="4">DT</option>
                    <option value="5">Finance</option>
                    <option value="6">HR</option>
                    <option value="7">Humanities</option>
                    <option value="8">ICT</option>
                    <option value="9">Learning Support</option>
                    <option value="10">Library</option>
                    <option value="11">MFL</option>
                    <option value="12">Music</option>
                    <option value="14">Science</option>
                    <option value="15">SLT</option>
                    <option value="16">Support Staff</option>
                </select>
                <br/>
                <select title="category" name="contentType" id="contentType">
                    <option value="">Category...</option>
                    {CATEGORIES}
                </select><br><br>
                <input type="text" name="location" id=location placeholder="Location">

            </div>

        </div>
    </div>

    <div class="center" style="width:60%;">
        <div class="left"><label for="attachFile">Attach a file for review: </label></div>
        <div class="right"><input name=attachfile id="attachFile" type="file"></div>
    </div>
    <br>
    <div class="logBoxDetails">
        <div class="details">
            <textarea title="content" name="content">{CONTENT}</textarea>
            <br/>
            <input class="btn btn-lg btn-default" name="submit" type="submit" value="Log Call"><br>
            {STATUS}
        </div>
    </div>
    </form>
</div>


</body>
</html>
