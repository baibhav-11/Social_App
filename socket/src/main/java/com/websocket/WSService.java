package com.websocket;

import java.util.List;

import org.apache.log4j.Logger;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.messaging.simp.SimpMessagingTemplate;
import org.springframework.stereotype.Service;

import com.websocket.dto.Comment;
import com.websocket.dto.Like;
import com.websocket.dto.ResponseComment;
import com.websocket.dto.ResponseLike;

@Service
public class WSService {

    private final SimpMessagingTemplate messagingTemplate;
    Logger log= Logger.getLogger(WSService.class);
    @Autowired
    public WSService(SimpMessagingTemplate messagingTemplate) {
        this.messagingTemplate = messagingTemplate;
    }
    public void notifyFrontendComments(final String name,final String detail, final String created_at, 
    		final String updated_at, final int id, final int user_id,final List<Comment> comment) {
        ResponseComment response = new ResponseComment(name,detail,created_at,updated_at, id,user_id,comment);
        messagingTemplate.convertAndSend("/topic/comments", response);
        log.info("Sending upcoming request to broadcast");
        log.info("The Comment data:\n");
        log.trace(response.toString());
    }
    public void notifyFrontendLikes(final int id, final int user_id,final int attachment_id,final String name,final String detail,
    		final String created_at,final String updated_at,final List<Like> likes) {
        ResponseLike response = new ResponseLike(id,user_id,attachment_id, name,detail,created_at,updated_at,likes);
        messagingTemplate.convertAndSend("/topic/likes", response);
        log.info("Sending upcoming request to broadcast");
        log.info("The Like data:\n");
        log.trace(response.toString());
    }

}