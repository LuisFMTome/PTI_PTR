<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet"/>
    <link href="style.css" rel="stylesheet"/>
</head>
<body>
    <main>
        <nav class="navigation">
            <div class="top-nav-bar">
                <div class="search-box">
                    <a href="index.html">
                        <img src="img/logotipo.png" class="logo">
                    </a>
                    <input type="text" class="form-control">
                    <span class="input-group-text"><i class="fa fa-search"></i></span>
                </div>
                <div class="menu-bar">
                    <ul>
                        <li><a href="index.html">Home</a></li>
                        <li><a href="produtos.html">Mercado</a></li>
                        <li><a href="conta.html"><i class="fa fa-user"></i></a></li>
                        <li><a href="carinho.html"><i class="fa fa-shopping-basket"></i></a></li>
                    </ul>
                </div>
            </div>
        </nav>
        
        <div class="container small-container carrinho-pagina">
            <table>
                <tr>
                    <th>Produto</th>
                    <th>Quantidade</th>
                    <th>Total</th>
                </tr>
                <tr>
                    <td>
                        <div class="carrinho-info">
                            <p>Produto 1</p>
                            <a href="">Remover</a>
                        </div>
                    </td>
                    <td><input type="number" value="1"></td>
                    <td>10€</td>
                </tr>
                <tr>
                    <td>
                        <div class="carrinho-info">
                            <p>Produto 2</p>
                            <a href="">Remover</a>
                        </div>
                    </td>
                    <td><input type="number" value="1"></td>
                    <td>10€</td>
                </tr>
                <tr>
                    <td>
                        <div class="carrinho-info">
                            <p>Produto 3</p>
                            <a href="">Remover</a>
                        </div>
                    </td>
                    <td><input type="number" value="1"></td>
                    <td>10€</td>
                </tr>
                <tr>
                    <td>
                        <div class="carrinho-info">
                            <p>Produto 4</p>
                            <a href="">Remover</a>
                        </div>
                    </td>
                    <td><input type="number" value="1"></td>
                    <td>10€</td>
                </tr>
                <tr>
                    <td>
                        <div class="carrinho-info">
                            <p>Produto 5</p>
                            <a href="">Remover</a>
                        </div>
                    </td>
                    <td><input type="number" value="1"></td>
                    <td>10€</td>
                </tr>
                <tr>
                    <td>
                        <div class="carrinho-info">
                            <p>Produto 6</p>
                            <a href="">Remover</a>
                        </div>
                    </td>
                    <td><input type="number" value="1"></td>
                    <td>10€</td>
                </tr>
                <tr>
                    <td>
                        <div class="carrinho-info">
                            <p>Produto 7</p>
                            <a href="">Remover</a>
                        </div>
                    </td>
                    <td><input type="number" value="1"></td>
                    <td>10€</td>
                </tr>
                <tr>
                    <td>
                        <div class="carrinho-info">
                            <p>Produto 8</p>
                            <a href="">Remover</a>
                        </div>
                    </td>
                    <td><input type="number" value="1"></td>
                    <td>10€</td>
                </tr>
            </table>
            <div class="total">
                <table>
                    <tr>
                        <td>Total</td>
                        <td id = "total">80</td>
                        <td>€</td>
                    </tr>
                    <tr>
                        <td> <div id="paypal-button-container"></div> </td>
                    </tr>
                </table>
            </div>
        </div>
        <section class="footer">
            <div class="container text-center">
                <div class="row">
                    <div class="col-md-3">
                        <h1>Links Úteis</h1>
                        <p>Política de Privacidade</p>
                        <p>Termos de Uso</p>
                        <p>Política de Returno</p>
                        <p>Cupões de Desconto</p>
                    </div>
                    <div class="col-md-3">
                        <h1>Grupo 10</h1>
                        <p>Sobre Nós</p>
                        <p>Contacta-nos</p>
                        <p>Faculdade de Ciências</p>
                        <p>Cupões de Desconto</p>
                    </div>
                    <div class="col-md-3 footer-image">
                        <img src="img/logofcul.jpg">
                        <p>Faculdade de Ciências da Universidade de Lisboa</p>
                    </div>
                </div>
            </div>
        </section>
    </main>
<script src="https://www.paypal.com/sdk/js?client-id=ATCfWOTCqypa0ftAUTCfSLiwM8UaQ0zUkWaDSzUIbFdQoo_bcR4mF_SDi7l-KJ5UXtZ3LcORC6FIhZ50&disable-funding=credit,card"></script>    <script>
        var price = document.getElementById("total");
        console.log(price.innerText);
        paypal.Buttons({
            style : {
                color: 'blue',
                shape: 'pill'
            },
            createOrder: function (data, actions) {
                return actions.order.create({
                    purchase_units : [{
                        amount: {
                            value: parseInt(price.innerText)
                        }
                    }]
                });
            },
            onApprove: function (data, actions) {
                return actions.order.capture().then(function (details) {
                    console.log(details)
                    window.location.replace("success.php")
                })
            },
            onCancel: function (data) {
                window.location.replace("Oncancel.php")
            }
        }).render('#paypal-button-container');
    </script>
</body>
</html>