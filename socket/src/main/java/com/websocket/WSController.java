package com.websocket;

import org.apache.log4j.Logger;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.RequestBody;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestMethod;
import org.springframework.web.bind.annotation.ResponseBody;
import org.springframework.web.bind.annotation.RestController;

import com.websocket.dto.Comment;
import com.websocket.dto.messageComment;
import com.websocket.dto.messageLike;

@RestController 
public class WSController {

    @Autowired
    private WSService service;
    Logger log= Logger.getLogger(WSController.class);
    @RequestMapping(value="/send-comment", method= RequestMethod.POST)
    @ResponseBody
    
    public messageComment sendMessage(@RequestBody final messageComment message) {
    	service.notifyFrontendComments(message.getName(),message.getDetail(),message.getCreated_at(),message.getUpdated_at(),message.getId(),
        		message.getUser_id(),message.getComments());
    	log.info("Request Broadcasted ");
    	return message;
    }
    @RequestMapping(value="/send-like", method= RequestMethod.POST)
    @ResponseBody
    
    public messageLike sendLike(@RequestBody final messageLike like) {
    	service.notifyFrontendLikes(like.getId(),like.getUser_id(),like.getAttachment_id(),like.getName(),like.getDetail(),like.getCreated_at(),
        		like.getUpdated_at(),like.getLikes());
    	log.info("Request Broadcasted ");
    	return like;
    }
}