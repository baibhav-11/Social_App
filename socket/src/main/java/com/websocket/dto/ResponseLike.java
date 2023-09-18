package com.websocket.dto;

import java.util.List;

public class ResponseLike {
	@Override
	public String toString() {
		return "[id=" + id + ", user_id=" + user_id + ", attachment_id=" + attachment_id + ", name=" + name
				+ ", detail=" + detail + ", created_at=" + created_at + ", updated_at=" + updated_at + ", likes="
				+ likes + "]";
	}


	private int id;
    private int user_id;
    private int attachment_id;
    private String name;
    private String detail;
    private String created_at;
    private String updated_at;
    private List<Like> likes;
    
    
    public ResponseLike(int id,int user_id,int attachment_id,String name,String detail, String created_at, String updated_at, List<Like> likes)
    {
    	this.id = id;
    	this.user_id = user_id;
    	this.attachment_id =attachment_id;
    	this.name=name;
    	this.detail=detail;
    	this.created_at = created_at;
    	this.updated_at = updated_at;
    	this.likes=likes;
    }


	public int getId() {
		return id;
	}


	public void setId(int id) {
		this.id = id;
	}


	public int getUser_id() {
		return user_id;
	}


	public void setUser_id(int user_id) {
		this.user_id = user_id;
	}


	public int getAttachment_id() {
		return attachment_id;
	}


	public void setAttachment_id(int attachment_id) {
		this.attachment_id = attachment_id;
	}


	public String getName() {
		return name;
	}


	public void setName(String name) {
		this.name = name;
	}


	public String getDetail() {
		return detail;
	}


	public void setDetail(String detail) {
		this.detail = detail;
	}


	public String getCreated_at() {
		return created_at;
	}


	public void setCreated_at(String created_at) {
		this.created_at = created_at;
	}


	public String getUpdated_at() {
		return updated_at;
	}


	public void setUpdated_at(String updated_at) {
		this.updated_at = updated_at;
	}


	public List<Like> getLikes() {
		return likes;
	}


	public void setLikes(List<Like> likes) {
		this.likes = likes;
	}
    
    
    
}
