<?php 
	session_start();
	function nombremes($mes){
      setlocale(LC_TIME, 'spanish');  
      $nombre=strftime("%B",mktime(0, 0, 0, $mes, 1, 2000)); 
      return $nombre;
  	}
	$json["exitoso"]=0;
	if(isset($_SESSION['correo'])){
		if(isset($_GET['id'])){
			$id=$_GET['id'];
			include "conexion.php";
			$sql="SELECT * FROM evento WHERE id=:id";
    		$r=$base->prepare($sql);
    		$r->execute(array(":id"=>$id));
        $registro=$r->fetch(PDO::FETCH_ASSOC);
        $date1=date_create($registro['fecha_ini']);
    		$date2=date_create($registro['fecha_fin']);
    		$registro['mesini']=nombremes(date_format($date1,'m'));
    		$registro['mesfin']=nombremes(date_format($date2,'m'));
    		$registro['diaini']=date_format($date1,'d');
    		$registro['diafin']=date_format($date2,'d');
    		$registro['horaini']=date_format($date1,'H:i');
    		$registro['horafin']=date_format($date2,'H:i');  
        $sql2="SELECT * FROM sala WHERE id=:sala";
        $resultado2=$base->prepare($sql2);
        $resultado2->execute(array(":sala"=>$registro['sala']));
        $reg=$resultado2->fetch(PDO::FETCH_ASSOC);
        $registro['sala']=$reg['nombre'];
        $json['datos']=$registro;
        $json['exitoso']=1;
    		
			header('Content-type: text/javascript');
    	}
	}
  echo json_encode($json);
 ?>