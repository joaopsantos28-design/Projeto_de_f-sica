<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Análise de Amostras de Água | Biofiltro</title>

    <!-- Bootstrap 5 (CSS apenas, sem JavaScript) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- CSS do projeto -->
    <link rel="stylesheet" href="../Templates/style.css">
</head>
<body>

    <nav class="navbar navbar-dark bg-primary mb-4">
        <div class="container">
            <span class="navbar-brand mb-0 h1">💧 Biofiltro &middot; Qualidade da Água</span>
        </div>
    </nav>

    <main class="container pb-5">
        <div class="row g-4">

            <!-- ========== FORMULÁRIO ========== -->
            <section class="col-lg-6">
                <div class="card">
                    <div class="card-body p-4">
                        <h2 class="h4 mb-1">Cadastro da amostra</h2>
                        <p class="text-muted mb-4">Preencha os parâmetros medidos. Use vírgula ou ponto como separador decimal.</p>

                        <!-- Alerta de erro (exibir apenas quando houver campos inválidos) -->
                        <div class="alert alert-danger" role="alert">
                            Corrija os campos destacados e envie novamente.
                        </div>

                        <form method="post" action="index.php" novalidate>
                            <div class="row g-3">

                                <div class="col-md-6">
                                    <label for="ph" class="form-label fw-semibold">pH</label>
                                    <div class="input-group has-validation">
                                        <input type="text" inputmode="decimal" class="form-control is-invalid"
                                               id="ph" name="ph" placeholder="Ex.: 7,2">
                                        <!-- Mensagem de erro (campo vazio / valor impossível) -->
                                        <div class="invalid-feedback">Campo obrigatório: preencha o pH.</div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="cloro" class="form-label fw-semibold">Cloro residual</label>
                                    <div class="input-group">
                                        <input type="text" inputmode="decimal" class="form-control"
                                               id="cloro" name="cloro" placeholder="Ex.: 1,0">
                                        <span class="input-group-text">mg/L</span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="temperatura" class="form-label fw-semibold">Temperatura</label>
                                    <div class="input-group">
                                        <input type="text" inputmode="decimal" class="form-control"
                                               id="temperatura" name="temperatura" placeholder="Ex.: 25">
                                        <span class="input-group-text">°C</span>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <hr class="my-1">
                                    <span class="faixa">Eficiência do biofiltro</span>
                                </div>

                                <div class="col-md-6">
                                    <label for="entrada" class="form-label fw-semibold">Concentração de entrada</label>
                                    <div class="input-group">
                                        <input type="text" inputmode="decimal" class="form-control"
                                               id="entrada" name="entrada" placeholder="Ex.: 100">
                                        <span class="input-group-text">mg/L</span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="saida" class="form-label fw-semibold">Concentração de saída</label>
                                    <div class="input-group">
                                        <input type="text" inputmode="decimal" class="form-control"
                                               id="saida" name="saida" placeholder="Ex.: 20">
                                        <span class="input-group-text">mg/L</span>
                                    </div>
                                </div>

                            </div>

                            <div class="d-flex gap-2 mt-4">
                                <button type="submit" class="btn btn-primary px-4">Analisar amostra</button>
                                <a href="index.php" class="btn btn-outline-secondary">Limpar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </section>

            <!-- ========== RESULTADO ========== -->
            <section class="col-lg-6">
                <div class="card">
                    <div class="card-body p-4">
                        <h2 class="h4 mb-3">Resultado da análise</h2>

                        <!-- Estado inicial (antes do envio) -->
                        <p class="text-muted mb-3">O resultado aparecerá aqui após o envio do formulário.</p>
                        <ul class="list-unstyled faixa mb-4">
                            <li>pH: 6,0 a 9,0</li>
                            <li>Cloro residual: 0,2 a 5,0 mg/L</li>
                            <li>Temperatura: 15 a 30 °C</li>
                            <li>Limites inclusivos (valor no limite = adequado).</li>
                        </ul>

                        <hr>

                        <!-- Exemplo do resultado após o envio -->
                        <div class="alert alert-success fw-semibold" role="alert">
                            Parecer final: Amostra adequada
                        </div>

                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead>
                                    <tr>
                                        <th>Parâmetro</th>
                                        <th>Valor</th>
                                        <th>Faixa</th>
                                        <th>Classificação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>pH</td>
                                        <td>7,20</td>
                                        <td class="faixa">6,0 a 9,0</td>
                                        <td><span class="badge text-bg-success">Adequado</span></td>
                                    </tr>
                                    <tr>
                                        <td>Cloro residual (mg/L)</td>
                                        <td>1,00</td>
                                        <td class="faixa">0,2 a 5,0</td>
                                        <td><span class="badge text-bg-success">Adequado</span></td>
                                    </tr>
                                    <tr>
                                        <td>Temperatura (°C)</td>
                                        <td>25,00</td>
                                        <td class="faixa">15 a 30</td>
                                        <td><span class="badge text-bg-success">Adequado</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="eficiencia p-3 rounded">
                            <div class="faixa">Eficiência do biofiltro</div>
                            <div class="fs-3 fw-bold">80,00%</div>
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </main>

</body>
</html>
