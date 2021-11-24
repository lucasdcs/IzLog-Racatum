<?php

declare(strict_types=1);

require_once '../vendor/autoload.php';

use Alfa\Database;
use Alfa\JsonResponse;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Factory\AppFactory;


$database = new Database(
    getenv('DATABASE_HOST'),
    getenv('DATABASE_NAME'),
    getenv('DATABASE_USER'),
    getenv('DATABASE_PASS')
);

$app = AppFactory::create();

$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});

$app->add(function ($request, $handler) {
    $response = $handler->handle($request);
    return $response
            ->withHeader('Access-Control-Allow-Origin', 'http://localhost:3000')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});

$app->get('/categoria', function(Request $request, Response $response) use ($database){
    $stmt = $database->prepare("select * from categoria");
    $stmt->execute();
    $categorias = $stmt->fetchAll(PDO::FETCH_OBJ);
    return JsonResponse::create($response, $categorias);
});

$app->get('/empresa', function(Request $request, Response $response) use ($database){
    $stmt = $database->prepare("select * from empresa");
    $stmt->execute();
    $empresas = $stmt->fetchAll(PDO::FETCH_OBJ);
    return JsonResponse::create($response, $empresas);
});

$app->post('/produto', function(Request $request, Response $response) use($database) {
    $stmt = $database->prepare("
        insert into produto 
        (produto, foto, descricao, valor, categoria_id, empresa_id)
        values        
        (:produto, :foto, :descricao, :valor, :categoria_id, :empresa_id)
    ");
    
    $produtoObj = json_decode($request->getBody()->getContents());
    file_put_contents('imagens/'.$produtoObj->nomeFoto, base64_decode($produtoObj->foto));
    $stmt->bindParam(':produto', $produtoObj->veiculo);
    $stmt->bindParam(':foto', $produtoObj->nomeFoto);
    $stmt->bindParam(':descricao', $produtoObj->descricao);
    $stmt->bindParam(':valor', $produtoObj->valor);
    $stmt->bindParam(':categoria_id', $produtoObj->marca_id);
    $stmt->bindParam(':empresa_id', $produtoObj->empresa_id);

    $stmt->execute();
    return JsonResponse::create(
        $response, 
        ['success' => true], 
        StatusCodeInterface::STATUS_CREATED
    );

});

$app->run();