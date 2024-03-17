<?php include("includes/acceso.php"); ?>
<?php
list($width, $height, $type, $attr) = getimagesize("imagenes/81000.jpg");

// Acceso a Datos
include_once("datos/d_actas.php");
$D_actas = new d_actas();

// Calculos y procesos

// Eventos Ajenos
if($_POST['enviar_mensaje']){
    //$Mensaje->nuevo_mensaje($_POST['mensaje'],$_POST['usuarios'],$_POST['evaluados'],$_POST['asunto']);
}
// Eventos Propios
if($_POST['nuevo_objeto']){
    $D_actas->nuevo_acta_elemento($_POST['nombre_elemento'],$_POST['numero'],$_POST['tipo_e'],$_POST['pos_x'],$_POST['pos_y'],$_POST['ancho'],$_POST['alto'],$_POST['img_an'],$_POST['img_al']);
    alerta("Objeto agregado");
    //include_once("bloques/actas/lista_mapeo.php");
    //exit();
}

if($_POST['borrar_mensaje']){
   /*
    if($_POST['id_mensaje']){
        $Mensaje->borrar_mensaje($_POST['id_mensaje']);
    }else{
        alerta("Por favor seleccione un mensaje");
    }
   */
}

if($_POST['ver_mensaje']){
    /*
    if($_POST['id_mensaje']){
        include_once("bloques/mensajes/ver_mensaje.php");
        exit();
    }else{
        alerta("Por favor seleccione un mensaje");
    }
    */
}
/*
echo "Ancho: " .$width;
echo '<br />';
echo "Alto: " .$height;
echo '<br />';
echo "Tipo: " .$type;
echo '<br />';
echo "Atributos: " .$attr;
*/
$D_actas->listar_acta_tipo_elemento();
?>
<div style="width:100%;overflow: scroll">

    <canvas id="myCanvas" width="<?php echo $width  ?>" height="<?php echo $height ?>" style="border:1px solid #d3d3d3;">
        Your browser does not support the HTML5 canvas tag.
    </canvas>
</div>

<button id="up">Arriba</button><button id="down">Abajo</button><button id="cancel">Cancelar</button><button
    id="clear">Borrar</button>
<form action="" method="post">
<div class="row">
    <div class="col-xs-12 col-md-6">
        <table class="table table-bordered table-striped">
            <tr>
                <td style="width: 100%"><b>Ancho</b></td>
                <td><input type="text" name="ancho" id="ancho" value="0"></td>
            </tr>
            <tr>
                <td><b>Alto</b></td>
                <td><input type="text" name="alto" id="alto" value="0"></td>
            </tr>
            <tr>
                <td><b>Posicion X</b></td>
                <td><input type="text" name="pos_x" id="pos_x" value="0"></td>

            </tr>
            <tr>
                <td><b>Posicion Y</b></td>
                <td><input type="text" name="pos_y" id="pos_y" value="0"></td>
            </tr>
            <tr>
                <td><b>Img. An</b></td>
                <td><input type="text" name="img_an" id="img_an" value="<?php echo $width ?>" ></td>
            </tr>
            <tr>
                <td><b>Img. Al</b></td>
                <td><input type="text" name="img_al" id="img_al" value="<?php echo $height ?>" ></td>
            </tr>
        </table>
        <hr/>
    </div>
    <div class="col-xs-12 col-md-6">
        <table class="table table-bordered table-striped">
            <tr>
                <td style="width: 100%"><b>Nombre de elemento</b></td>
                <td><input type="text" name="nombre_elemento" id="nombre_elemento" ></td>
            </tr>
            <tr>
                <td><b>Número</b></td>
                <td><input type="number" name="numero" id="numero" value="0"></td>
            </tr>
            <tr>
                <td><b>Tipo de Elemento</b></td>
                <td><select name="tipo_e" id="">
                        <?php
                        for($i=0; $i < $D_actas->num_filas; $i++){
                            echo "<option value='" . $D_actas->datos[$i]->id_te . "'>" . $D_actas->datos[$i]->nombre
                                ."</option>";
                        }
                        ?>

                    </select>

            </tr>
            <tr>
                <td rowspan="2">
                    <input type="submit" name="nuevo_objeto" id="nuevo_objeto" value="Agregar Objeto">

                </td>
            </tr>
        </table>
        <hr/>
    </div>
</div>
</form>
<script>
    const c=document.getElementById("myCanvas");
    const ctx=c.getContext("2d");
    const scaleStep=1;
    const minWidth=1180,minHeight=800,maxWidth=9000,maxHeight=7000;
    const img=document.createElement('img');

    const elementWidth=<?php echo $width ?>,elementHeight=<?php echo $height ?>;

    let startx,//起始x坐标
        starty,//起始y坐标
        flag,//是否点击鼠标的标志
        x,
        y,
        leftDistance,
        topDistance,
        op=0,//op操作类型 0 无操作 1 画矩形框 2 拖动矩形框
        scale=1,
        type=0;
    //let layers=[];//图层
    let layers=[];//图层
    let currentR;//当前点击的矩形框
    img.src='imagenes/81000.jpg';
    // img.src='png';
    img.onload=function(){
        c.style.backgroundImage="url("+img.src+")";
        c.style.backgroundSize='${c.width}px ${c.height}px';
    }
    document.querySelector('#up').onclick=function(){
        if(c.width<=maxWidth&&c.height<=maxHeight){
            c.width*=scaleStep;
            c.height*=scaleStep;
            scale=c.height/minHeight;
            ctx.scale(scale,scale);
            c.style.backgroundSize='${c.width}px ${c.height}px';
            reshow();
        }
    };
    document.querySelector('#down').onclick=function(){
        if(c.width>=minWidth&&c.height>=minHeight){
            c.width/=scaleStep;
            c.height/=scaleStep;
            scale=c.height/minHeight;
            ctx.scale(scale,scale);
            c.style.backgroundSize='${c.width}px ${c.height}px';
            reshow();
        }

    }
    document.querySelector('#cancel').onclick=function(){
        layers.pop();
        ctx.clearRect(0,0,elementWidth,elementHeight);
        reshow();
    }
    document.querySelector('#clear').onclick=function(){
        layers=[];
        ctx.clearRect(0,0,elementWidth,elementHeight);
        reshow();
    }
    function resizeLeft(rect){
        c.style.cursor="w-resize";
        if(flag&&op==0){op=3;}
        if(flag&&op==3){
            if(!currentR){currentR=rect}
            currentR.x1=x
            currentR.width=currentR.x2-currentR.x1
        }
    }
    function resizeTop(rect){
        c.style.cursor="s-resize";
        if(flag&&op==0){op=4;}
        if(flag&&op==4){
            if(!currentR){currentR=rect}
            currentR.y1=y
            currentR.height=currentR.y2-currentR.y1
        }
    }
    function resizeWidth(rect){
        c.style.cursor="w-resize";
        if(flag&&op==0){op=5;}
        if(flag&&op==5){
            if(!currentR){currentR=rect}
            currentR.x2=x;
            currentR.width=currentR.x2-currentR.x1
        }
    }
    function resizeHeight(rect){
        c.style.cursor="s-resize";
        if(flag&&op==0){op=6;}
        if(flag&&op==6){
            if(!currentR){currentR=rect}
            currentR.y2=y
            currentR.height=currentR.y2-currentR.y1
        }
    }
    function resizeLT(rect){
        c.style.cursor="se-resize";
        if(flag&&op==0){op=7;}
        if(flag&&op==7){
            if(!currentR){currentR=rect}
            currentR.x1=x
            currentR.y1=y
            currentR.height=currentR.y2-currentR.y1
            currentR.width=currentR.x2-currentR.x1
        }
    }
    function resizeWH(rect){
        c.style.cursor="se-resize";
        if(flag&&op==0){op=8;}
        if(flag&&op==8){
            if(!currentR){currentR=rect}
            currentR.x2=x
            currentR.y2=y
            currentR.height=currentR.y2-currentR.y1
            currentR.width=currentR.x2-currentR.x1
        }
    }
    function resizeLH(rect){
        c.style.cursor="ne-resize";
        if(flag&&op==0){op=9;}
        if(flag&&op==9){
            if(!currentR){currentR=rect}
            currentR.x1=x
            currentR.y2=y
            currentR.height=currentR.y2-currentR.y1
            currentR.width=currentR.x2-currentR.x1
        }
    }
    function resizeWT(rect){
        c.style.cursor="ne-resize";
        if(flag&&op==0){op=10;}
        if(flag&&op==10){
            if(!currentR){currentR=rect}
            currentR.x2=x
            currentR.y1=y
            currentR.height=currentR.y2-currentR.y1
            currentR.width=currentR.x2-currentR.x1
        }
    }
    function reshow(x,y){
        let allNotIn=1;
        layers.forEach(item=>{
            ctx.beginPath();
            ctx.rect(item.x1,item.y1,item.width,item.height);
            document.getElementById('ancho').value = item.width;
            document.getElementById('alto').value = item.height;
            document.getElementById('pos_x').value = item.x1;
            document.getElementById('pos_y').value = item.y1;
            ctx.strokeStyle=item.strokeStyle;
            if(x>=(item.x1-25/scale)&&x<=(item.x1+25/scale)&&y<=(item.y2-25/scale)&&y>=(item.y1+25/scale)){
                resizeLeft(item);
            }else if(x>=(item.x2-25/scale)&&x<=(item.x2+25/scale)&&y<=(item.y2-25/scale)&&y>=(item.y1+25/scale)){
                resizeWidth(item);
            }else if(y>=(item.y1-25/scale)&&y<=(item.y1+25/scale)&&x<=(item.x2-25/scale)&&x>=(item.x1+25/scale)){
                resizeTop(item);
            }else if(y>=(item.y2-25/scale)&&y<=(item.y2+25/scale)&&x<=(item.x2-25/scale)&&x>=(item.x1+25/scale)){
                resizeHeight(item);
            }else if(x>=(item.x1-25/scale)&&x<=(item.x1+25/scale)&&y<=(item.y1+25/scale)&&y>=(item.y1-25/scale)){
                resizeLT(item);
            }else if(x>=(item.x2-25/scale)&&x<=(item.x2+25/scale)&&y<=(item.y2+25/scale)&&y>=(item.y2-25/scale)){
                resizeWH(item);
            }else if(x>=(item.x1-25/scale)&&x<=(item.x1+25/scale)&&y<=(item.y2+25/scale)&&y>=(item.y2-25/scale)){
                resizeLH(item);
            }else if(x>=(item.x2-25/scale)&&x<=(item.x2+25/scale)&&y<=(item.y1+25/scale)&&y>=(item.y1-25/scale)){
                resizeWT(item);
            }
            if(ctx.isPointInPath(x*scale,y*scale)){
                render(item);
                allNotIn=0;
            }
            ctx.stroke();
        })
        if(flag&&allNotIn&&op<3){
            op=1
        }

    }
    function render(rect){
        debugger;
        c.style.cursor="move";
        if(flag&&op==0){op=2;}
        if(flag&&op==2){
            if(!currentR){currentR=rect}
            currentR.x2+=x-leftDistance-currentR.x1
            currentR.x1+=x-leftDistance-currentR.x1
            currentR.y2+=y-topDistance-currentR.y1
            currentR.y1+=y-topDistance-currentR.y1
        }
    }
    function isPointInRetc(x,y){
        let len=layers.length;
        for(let i=0;i<len;i++){
            if(layers[i].x1<x&&x<layers[i].x2&&layers[i].y1<y&&y<layers[i].y2){
                return layers[i];
            }
        }
    }
    function fixPosition(position){
        if(position.x1>position.x2){
            let x=position.x1;
            position.x1=position.x2;
            position.x2=x;
        }
        if(position.y1>position.y2){
            let y=position.y1;
            position.y1=position.y2;
            position.y2=y;
        }
        position.width=position.x2-position.x1
        position.height=position.y2-position.y1
        // if(position.width<50||position.height<50){
        //     position.width=60;
        //     position.height=60;
        //     position.x2+=position.x1+60;
        //     position.y2+=position.y1+60;
        // }
        if(position.width<10||position.height<10){
            position.width=15;
            position.height=15;
            position.x2+=position.x1+15;
            position.y2+=position.y1+15;
        }
        return position
    }
    let mousedown=function(e){
        startx=(e.pageX-c.offsetLeft+c.parentElement.scrollLeft)/scale;
        starty=(e.pageY-c.offsetTop+c.parentElement.scrollTop)/scale;
        currentR=isPointInRetc(startx,starty);
        if(currentR){
            leftDistance=startx-currentR.x1;
            topDistance=starty-currentR.y1;
        }
        ctx.strokeRect(x,y,0,0);
        ctx.strokeStyle="#0000ff";
        flag=1;
    }
    let mousemove=function(e){
        x=(e.pageX-c.offsetLeft+c.parentElement.scrollLeft)/scale;
        y=(e.pageY-c.offsetTop+c.parentElement.scrollTop)/scale;
        ctx.save();
        ctx.setLineDash([5]);
        c.style.cursor="default";
        ctx.clearRect(0,0,elementWidth,elementHeight);
        if(flag&&op==1){
            ctx.strokeRect(startx,starty,x-startx,y-starty);
        }
        ctx.restore();
        reshow(x,y);
    }
    let mouseup=function(e){
        if(op==1){
            layers.push(fixPosition({
                x1:startx,
                y1:starty,
                x2:x,
                y2:y,
                strokeStyle:'#0000ff',
                type:type
            }))
        }else if(op>=3){
            fixPosition(currentR)
        }
        currentR=null;
        flag=0;
        reshow(x,y);
        op=0;
    }
    c.onmouseleave=function(){
        c.onmousedown=null;
        c.onmousemove=null;
        c.onmouseup=null;
    }
    c.onmouseenter=function(){
        c.onmousedown=mousedown;
        c.onmousemove=mousemove;
        document.onmouseup=mouseup;
    }
</script>