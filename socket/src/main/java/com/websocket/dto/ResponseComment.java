package com.websocket.dto;

import java.util.List;

public class ResponseComment {
    
    @Override
	public String toString() {
		return "ResponseComment [name=" + name + ", detail=" + detail + ", created_at=" + created_at + ", updated_at="
				+ updated_at + ", id=" + id + ", user_id=" + user_id + ", comment=" + comments + "]";
	} 
    
    
	


	public ResponseComment(String name, String detail, String created_at, String updated_at, int id, int user_id,
			List<Comment> comments) {
		this.name = name;
		this.detail = detail;
		this.created_at = created_at;
		this.updated_at = updated_at;
		this.id = id;
		this.user_id = user_id;
		this.comments = comments;
	}





	private String name;
    private String detail;
    private String created_at;
    private String updated_at;
    private int id;
    private int user_id;
    private List<Comment> comments;
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


	public List<Comment> getComments() {
		return comments;
	}


	public void setComments(List<Comment> comments) {
		this.comments = comments;
	}
	
    
}