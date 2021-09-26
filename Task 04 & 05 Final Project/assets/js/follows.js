const followUser = async (userId, loggedId) => {
    try {
        let req = await fetch(
            `${apiUrl}/follow.php?follower_id=${loggedId}&following_id=${userId}`
        );
        await req;

        console.log(
            `${apiUrl}/follow.php?follower_id=${loggedId}&following_id=${userId}`
        );
    } catch (ex) {
        console.log(ex);
    } finally {
        window.location.reload();
    }
};

const unFollowUser = async (userId, loggedId) => {
    try {
        let req = await fetch(
            `${apiUrl}/unfollow.php?follower_id=${loggedId}&following_id=${userId}`
        );
        await req;

        console.log(
            `${apiUrl}/follow.php?follower_id=${loggedId}&following_id=${userId}`
        );
    } catch (ex) {
        console.log(ex);
    } finally {
        window.location.reload();
    }
};
