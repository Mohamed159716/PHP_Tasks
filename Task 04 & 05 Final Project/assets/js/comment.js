"use strict";

const likeComment = async (id) => {
    let commentLikeBtn = document.querySelector(`#comment_like_${id}`);
    commentLikeBtn.setAttribute("disabled", "disabled");

    try {
        let req = await fetch(`${apiUrl}/commentlike.php?id=${id}`);
        if (!req.ok) throw "Request Not Found";
        await req;
        let oldCount = +document.querySelector(`#comment_like_${id} span`)
            .innerHTML;
        document.querySelector(`#comment_like_${id} span`).innerHTML =
            oldCount + 1;
        document.querySelector(`#comment_unlike_${id} span`).innerHTML =
            oldCount + 1;
        commentLikeBtn.style.display = "none";
        document.querySelector(`#comment_unlike_${id}`).style.display = "block";
    } catch (ex) {
        console.log(ex);
    } finally {
        commentLikeBtn.removeAttribute("disabled");
    }
};

const unLikeComment = async (id) => {
    let unlikeCommentBtn = document.querySelector(`#comment_unlike_${id}`);
    unlikeCommentBtn.setAttribute("disabled", "disabled");
    try {
        let req = await fetch(`${apiUrl}/commentunlike.php?id=${id}`);
        if (!req.ok) throw "Request Not Found";
        await req;
        let oldCount = +document.querySelector(`#comment_unlike_${id} span`)
            .innerHTML;
        if (oldCount <= 1) oldCount = 1;
        document.querySelector(`#comment_unlike_${id} span`).innerHTML =
            oldCount - 1;
        document.querySelector(`#comment_like_${id} span`).innerHTML =
            oldCount - 1;
        unlikeCommentBtn.style.display = "none";
        document.querySelector(`#comment_like_${id}`).style.display = "block";
    } catch (ex) {
        console.log(ex);
    } finally {
        unlikeCommentBtn.removeAttribute("disabled");
    }
};

const deleteComment = async (id) => {
    let deleteCommentBtn = document.querySelector(`#comment_trash_${id}`);
    deleteCommentBtn.setAttribute("disabled", "disabled");
    try {
        let req = await fetch(`${apiUrl}/deletecomment.php?id=${id}`);
        if (!req.ok) throw "Bad Request";
        await req;
        deleteCommentBtn.parentElement.parentElement.parentElement.remove();
    } catch (ex) {
        console.log(ex);
    }
};

async function commentCreation(e, id) {
    if (13 === e.keyCode) {
        try {
            let comment = document.querySelector(`#comment_field_${id}`);
            let req = await fetch(
                `${apiUrl}/createcomment.php?id=${id}&comment=${comment.innerText}`
            );
            await req;
            comment.innerHTML = "";
        } catch (ex) {
            console.log(ex);
        } finally {
            window.location.reload();
        }
    }
}

function redirectToLogin(e) {
    if (13 == e.keyCode) {
        window.location.href = "login.php";
    }
}

function shoComments(id) {
    document
        .querySelector(`#comments_section_${id}`)
        .classList.toggle("d-none");
    document.querySelector(`#comments_input_${id}`).classList.toggle("d-none");
    document.querySelector(`#comment_hr_${id}`).classList.toggle("d-none");
}
