import { comment } from "./actions";

export function setPosts(state, payload) {
    
    state.posts = payload
}

export function setLike(state, payload) {
    let post = state.posts.find(post => post.id == payload.post.id)

    post.likes.push({
        'post_id': payload.post.id,
        'user_id': payload.authUser.id
    });

    // state.posts.find(post => post.id == payload.post.id).likes.push({
    //     'post_id' => payload.post.in,
    //     'user_id' => payload.authUser.in
    //     })

    state.posts.find(post => { if (post.id == payload.post.id) { post = post } })
}


export function disLike(state, payload) {
            
    let post = state.posts.find(post => post.id == payload.post.id)

    let like = post.likes.find(like => like.user_id == payload.authUser.id)
    post.likes.splice(post.likes.indexOf(like), 1)

    state.posts.find(post => { if (post.id == post.id) { post = post } })
}

export function setComment(state, payload) {
            
    let post = state.posts.find(post => post.id == payload.post.id)

    post.comments.unshift({
        'id': payload.comment.id,
        'post_id': payload.post.id,
        'user_id': payload.authUser.id,
        'comment': payload.comment.comment,
        'user': payload.authUser,
        'replies': []
    });

    state.posts.find(post => { if (post.id == post.id) { post = post } })
}


export function sendReply(state, payload) {
            
    let post = state.posts.find(post => post.id == payload.commentData.post_id)

    let comment = post.comments.find(comment => comment.id == payload.commentData.id)
    
    comment.replies.unshift({
        'id': payload.comment.id,
        'post_id': post.id,
        'user_id': payload.authUser.id,
        'parent_id': comment.id,
        'comment': payload.comment.comment,
        'user': payload.authUser
    });

    post = post.comments.find(comment => {if (comment.id == payload.commentData.id) {{ comment = comment }}})
    state.posts.find(post => { if (post.id == post.id) { post = post } })
}
