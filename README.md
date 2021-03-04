
# PHPMask

PHP Mask é uma biblioteca para aplicar máscaras simples em string.


# Uso

Utilize o método estático `apply` da classe `Mask`

```
use PHPMask\Mask;
$output = Mask::apply('12345678978','###.###.###-##');
//output: 123.456.789-78
```

## Parâmentros

* `$inputValue`: string de entrada a ser aplicada a máscara
* `$mask`: string contendo o formato da máscara a ser aplicada
* `$fillChar`: caractere para preencher caso a string de entrada for menos que os caracteres(#) da máscara. Padrão "0".
* `$direction`: Direção em que os caracteres da entrada serão colocados na mascara. Aceita os valores das constantes `Mask::DIRECTION_LEFT` e `Mask::DIRECTION_RIGHT`. Padrão `Mask::DIRECTION_LEFT`.

### Máscara
Para formar a mascar utilize caracteres **#** nas posições em que deseja que os valores de entrada sejam substituidos. Ao utilizar o caracter de um **\*** ele será substituido por todos os caracteeres de entrada restante. Caracteres diferentes de **#** e __*__ permanecerão inalterados.


## Exemplos
```
$output = Mask::apply('123','###.###');
//output: 123.000

$output = Mask::apply('1234','###.###', '-');
//output: 123.4--

$output = Mask::apply('1234','###.###', null, Mask::DIRECTION_RIGHT);
//output: 001.234

$output = Mask::apply('12345','C-####');
//output: C-1234

$output = Mask::apply('123456789','C-#.#.#*');
//output: C-1.2.3456789
```