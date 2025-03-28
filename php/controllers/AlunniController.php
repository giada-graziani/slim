<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AlunniController
{
  public function index(Request $request, Response $response, $args){
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $result = $mysqli_connection->query("SELECT * FROM alunni");
    $results = $result->fetch_all(MYSQLI_ASSOC);

    $response->getBody()->write(json_encode($results));
    return $response->withHeader("Content-type", "application/json")->withStatus(200);
  }

  public function view(Request $request, Response $response, $args){
    $id = $args['id'];
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $result = $mysqli_connection->query("SELECT * FROM alunni WHERE id='$id'");
    $results = $result->fetch_all(MYSQLI_ASSOC);//scorre l'array per visualizzare tutti gli alunni
    
    if($results){
      $response->getBody()->write(json_encode($results));
    }
    else{
      $response->getBody()->write("{'messaggio':'not found'}");
    }
      return $response->withHeader("Content-type", "application/json")->withStatus(200);
  }

  /*curl -X POST localhost:8080/alunni --data '{"nome":"giafdsfdfda","cognome":"grdfdfdaziani","codiceF":"nnnnnnnnnnnnnnnn"}' -H "Content-Type:application/json"*/
  public function create(Request $request, Response $response, $args){

    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $body=json_decode($request->getbody()->getContents(), true);
    $nome= $body["nome"];
    $cognome=$body["cognome"];
    $codiceF=$body["codiceF"];

    $result = $mysqli_connection->query("INSERT INTO alunni(nome,cognome,codiceF) VALUES('$nome','$cognome','$codiceF')");

    if($result){
      $response->getBody()->write("{'status':'created'}");
    }
    else{
      $response->getBody()->write("{'status':'not found'}");
    }

    return $response->withHeader("Content-type", "application/json")->withStatus(201);
  }

  /*curl -X PUT localhost:8080/alunni/4 --data '{"nome":"gaia","cognome":"bottai,"codiceF":"kkkkkkkkkkkkkkk"}' -H "Content-Type:application/json"*/
  public function update(Request $request, Response $response, $args){
    $id = $args['id'];
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $body=json_decode($request->getbody()->getContents(), true);
    $nome= $body["nome"];
    $cognome=$body["cognome"];
    $codiceF=$body["codiceF"];

    $result = $mysqli_connection->query("UPDATE alunni SET nome='$nome',cognome='$cognome', codiceF='$codiceF' WHERE id=$id");

    if($result){
      $response->getBody()->write("{'status':'ok'}");
    }
    else{
      $response->getBody()->write("{'status':'404 not found'}");
    }

    return $response->withHeader("Content-type", "application/json")->withStatus(200);
  }

 /*curl -X DELETE localhost:8080/alunni/2 */
 public function destroy(Request $request, Response $response, $args){
  $id = $args['id'];
  $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
  $result = $mysqli_connection->query("DELETE FROM alunni WHERE id=$id");

  if($result){
    $response->getBody()->write("{'status':'ok'}");
  }
  else{
    $response->getBody()->write("{'status':'404 not found'}");
  }

  return $response->withHeader("Content-type", "application/json")->withStatus(204);
}

  // ?search=cla&sortCol=cognome&sort=desc
  public function search(Request $request, Response $response, $args){
    $parametri = $request->getQueryParams();
    $inizioNome = $parametri['search'] ?? null;
    $colonna = $parametri['sortCol'] ?? null;
    $ordine= $parametri['sort'] ?? null;
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');

    $result = $mysqli_connection->query("SELECT * FROM alunni WHERE nome LIKE '%$inizioNome%' ORDER BY $colonna $ordine");
      $results = $result->fetch_all(MYSQLI_ASSOC);
      
      if($result){
         $response->getBody()->write(json_encode($results));
      }
      else{
        $response->getBody()->write("{'status':'404 not found'}");
      }

      return $response->withHeader("Content-type", "application/json")->withStatus(200);
  }
}
