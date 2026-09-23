DEFINIÇÃO DO ESCOPO 
Os testes serão realizados nas funcionalidades responsáveis pelo cadastro e análise de amostras de água, classificação dos parâmetros de qualidade, cálculo da eficiência do biofiltro e geração do parecer final da amostra. O objetivo é garantir que os dados inseridos pelo usuário sejam devidamente processados, que os algoritmos de cálculo apresentem resultados corretos e que as classificações dos parâmetros estejam de acordo com as faixas de referência definidas para o projeto. 

O OBJETIVO DOS TESTES É GARANTIR QUE: 
● Os dados de uma amostra sejam recebidos e processados corretamente;  
● Os valores dos parâmetros de qualidade da água sejam validados; 
● O PH seja classificado corretamente de acordo com a faixa de referência adotada;  
● O cloro residual seja classificado corretamente; 
A temperatura seja processada e classificada de acordo com os critérios definidos;  
● Valores exatamente nos limites das faixas sejam tratados corretamente; 
●   Valores fora das faixas de referência sejam classificados corretamente;
Valores fisicamente impossíveis ou inválidos sejam rejeitados;
Campos obrigatórios ausentes sejam identificados; 
Retornar o resultado da medição na tela para o usuário  

ABORDAGEM DOS TESTES 
Os testes serão realizados utilizando o PHPUnit, framework de testes unitários para a linguagem PHP, com o objetivo de verificar a corretude dos algoritmos responsáveis pelos cálculos e classificações dos parâmetros de qualidade da água. 

OS TESTES SERÃO BEM SUCEDIDOS SE: 
Se os valores inseridos estiverem corretos;
Se parâmetros dentro das faixas de referência receberem a classificação esperada; 
Se valores fora das faixas forem classificados corretamente; 
Se valores irrealistas são negados;
Se campos obrigatórios ausentes mostram mensagem de campo vazio;
Se os testes de integração retornarem os resultados esperados; 
Se o resultado aparecer na tela;


OS TESTES NÃO SERÃO BEM SUCEDIDOS SE: 
● Valores válidos forem classificados incorretamente; 
● Valores dentro da faixa de referência forem considerados inadequados 
● Valores fora das faixas forem considerados adequados; 
● Valores fisicamente impossíveis forem aceitos; 
● Campos obrigatórios vazios forem processados como dados válidos; 
● O sistema realizar uma divisão por zero sem tratamento; 
● Existirem testes PHPUnit falhando; 
O AMBIENTE DE TESTE SERÁ CONFIGURADO EM: 
● Ferramentas: Visual Studio Code, Laravel Herd,  Composer.
Framework de testes: PHPUnit;  
Interface: HTML5, CSS3 e Bootstrap 
Repositório: GitHub; 
Linguagem: PHP 8.4 ou superior e PHPunit; 
● 	Sistema operacional: Windows. 
