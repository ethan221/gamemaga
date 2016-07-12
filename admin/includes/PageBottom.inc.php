<?php
if($_num>0){
?>
            <div class="page">
            <ul>
                <li class="text">每页显示<?php echo $_pagesize;?>条</li>
                <li class="text">共<?php echo $_num;?>条数据</li>
                <li class="text">第<?php echo $_page;?>页/共<?php echo $_pageabsolute;?>页</li>
                <?php
                if($_page!=1){
                ?>
                <li><a href="?page=1&id=<?php echo $id; ?>">首页</a></li>
               <?php
                }else{
                ?>
                <li class="nolink">首页</li>
                <?php
                }                
               if($_page-1<1){
               ?>
                        <li class="nolink">上一页</li>
               <?php
               }else{
               ?>
                        <li><a href="?page=<?php echo $_page+1;?>&id=<?php echo $id; ?>">上一页</a></li>
               <?php
               }
               ?>
               <?php
               if(($_page-2)>0){
               ?>
                        <li><a href="?page=<?php echo $_page-2;?>&id=<?php echo $id; ?>"><?php echo $_page-2;?></a></li>
               <?php
               }
               ?>
                <?php
               if(($_page-1)>0){
               ?>
                        <li><a href="?page=<?php echo $_page-1;?>&id=<?php echo $id; ?>"><?php echo $_page-1;?></a></li>
               <?php
               }
               ?>
                        <li class="me"><?php echo $_page;?></li>
               <?php
               if(($_page+1)<=$_pageabsolute){
               ?>
                        <li><a href="?page=<?php echo $_page+1;?>&id=<?php echo $id; ?>"><?php echo $_page+1;?></a></li>
               <?php
               }
               ?>
               <?php
               if(($_page+2)<=$_pageabsolute){
               ?>
                        <li><a href="?page=<?php echo $_page+2;?>&id=<?php echo $id; ?>"><?php echo $_page+2;?></a></li>
               <?php
               }
               if($_page+1<=$_pageabsolute){
               ?>
                        <li><a href="?page=<?php echo $_page+1;?>&id=<?php echo $id; ?>">下一页</a></li>
               <?php
               }else{
               ?>
                        <li class="nolink">下一页</li>
               <?php
               }
               if($_page!=$_pageabsolute){
               ?>
                        <li><a href="?page=<?php echo $_pageabsolute;?>&id=<?php echo $id; ?>">尾页</a></li>
               <?php
               }else{
               ?>
                        <li class="nolink">尾页</li>
               <?php
               }
               ?>
            </ul>                
        </div>
<?php
 }
?>