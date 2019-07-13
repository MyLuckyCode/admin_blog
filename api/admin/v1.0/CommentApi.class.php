<?php


class CommentApi extends Api{
	public function deleteComment(){    //删除评论
        $comment = new CommentModel();
        if($comment->deleteComment()){
            echo '{"state":"succ","info":"删除成功"}';
        }else {
            echo '{"state":"error","info":"删除失败"}';
        }
    }
	
}






?>