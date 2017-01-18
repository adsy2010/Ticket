<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Log Call</title>
    <link rel="stylesheet" href="templates/css.css">
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
                <b>Username: </b>AWT <br><br>
                <select title="department" name="department" id="department">
                    <option value="0">Department...</option>
                    <option value="1">Art</option>
                    <option value="2">Drama</option>
                    <option value="3">DT</option>
                    <option value="4">Humanities</option>
                    <option value="5">ICT</option>
                    <option value="6">Music</option>
                    <option value="7">Science</option>
                </select>
                <br/>
                <select title="category" name="category" id="category">
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
            <textarea title="content" name="content">
                Tamen a proposito, inquam, aberramus. Philosophi autem in suis lectulis plerumque moriuntur. Quantum Aristoxeni ingenium consumptum videmus in musicis? An vero, inquit, quisquam potest probare, quod perceptfum, quod. Illud dico, ea, quae dicat, praeclare inter se cohaerere. Homines optimi non intellegunt totam rationem everti, si ita res se habeat. Quid censes in Latino fore? At cum de plurimis eadem dicit, tum certe de maximis. Portenta haec esse dicit, neque ea ratione ullo modo posse vivi; De ingenio eius in his disputationibus, non de moribus quaeritur. Virtutibus igitur rectissime mihi videris et ad consuetudinem nostrae orationis vitia posuisse contraria. Hanc ergo intuens debet institutum illud quasi signum absolvere.
            </textarea>
            <br/>
            <input name="submit" type="submit" value="Log Call"><br>
            {STATUS}
        </div>
    </div>
    </form>
</div>


</body>
</html>
