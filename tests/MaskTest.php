<?php

declare(strict_types=1);

use PHPMask\Mask;

test('Deve aplicar máscara', function(){

    $output = Mask::apply('123','###');

    expect($output)->toBe('123');
    
});

test('Deve permitir caracteres diferentes da máscara',function(){

    $output = Mask::apply('123','SUF###');
    expect($output)->toBe('SUF123');

    $output = Mask::apply('12345678978','###.###.###-##');

    expect($output)->toBe('123.456.789-78');

});


test('Deve preencheer com 0 se faltar caracteres no input', function(){

    $output = Mask::apply('123', '######');
    expect($output)->toBe('123000');
});

test('Deve permitir alterar o caracter de preenchimento', function(){

    $output = Mask::apply('123', '######' , '-');
    expect($output)->toBe('123---');

});

test('Não deve aceitar um caractere de preenchimento com mais de um caractere', function(){

    $output = Mask::apply('123', '######' , '-0');

})->throws(InvalidArgumentException::class);

test('Deve permitir alterar a direção de preenchimento da máscara', function(){

    $output = Mask::apply('123', '######', null, Mask::DIRECTION_RIGHT);
    expect($output)->toBe('000123');

});


test('Deve aceitar caractere coringa (*) que adiciona todos caracteres da entrada', function(){

    $output = Mask::apply('123456', 'C-#*');
    expect($output)->toBe('C-123456');

    $output = Mask::apply('123456', 'C-#*BR');
    expect($output)->toBe('C-123456BR');

    $output = Mask::apply('123456', 'C-*#', null, Mask::DIRECTION_RIGHT);
    expect($output)->toBe('C-123456');

});