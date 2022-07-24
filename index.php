<?php include("{$_SERVER['DOCUMENT_ROOT']}/shopmee/pages/header.php"); ?>

<form class="container" action="tableRegistration.php" method="post">
    <div class="boxContainer"> 
        <div>
            <img src="images/shopmee.svg" alt="Shopmee" />
        </div>
        <div>
            <span>Newsletter</span>

            <h1>Inscreva-se na nossa newsletter.</h1>

            <input name="email" placeholder="Informe o seu melhor e-mail" type="text">

            <button type="submit">
                Inscrever-me
            </button>
        </div>
    </div>
</form>

<?php include("{$_SERVER['DOCUMENT_ROOT']}/shopmee/pages/footer.php"); ?>