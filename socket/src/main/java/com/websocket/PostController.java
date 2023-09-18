package com.websocket;

import org.apache.log4j.Logger;
import org.springframework.messaging.handler.annotation.MessageMapping;
import org.springframework.messaging.handler.annotation.SendTo;
import org.springframework.stereotype.Controller;

import com.websocket.dto.messageComment;
import com.websocket.dto.messageLike;
import com.websocket.dto.ResponseComment;
import com.websocket.dto.ResponseLike;

 
@Controller
public class PostController {
    @MessageMapping("/comment")   
    @SendTo("/topic/comments") 
    public ResponseComment getMessage(final messageComment message) throws InterruptedException {
        Thread.sleep(1000);
        return new ResponseComment(message.getName(),message.getDetail(),message.getCreated_at(),message.getUpdated_at(),message.getId(),
        		message.getUser_id(),message.getComments());
    }
    @MessageMapping("/like")   
    @SendTo("/topic/likes") 
    public ResponseLike getLike(final messageLike like) throws InterruptedException {
        Thread.sleep(1000);
        return new ResponseLike(like.getId(),like.getUser_id(),like.getAttachment_id(),like.getName(),like.getDetail(),like.getCreated_at(),
        		like.getUpdated_at(),like.getLikes());
    }
}
