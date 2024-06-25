// Get the modal
var loginModal = document.getElementById('loginModal');
var signupModal = document.getElementById('signupModal');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == loginModal) {
        loginModal.style.display = "none";
    }
    if (event.target == signupModal) {
        signupModal.style.display = "none";
    }
}
document.addEventListener('DOMContentLoaded', () => {
    loadPosts();

    const newPostForm = document.getElementById('newPostForm');
    newPostForm.addEventListener('submit', event => {
        event.preventDefault();
        createNewPost(newPostForm);
    });
});

function loadPosts() {
    fetch('php/get_posts.php')
        .then(response => response.json())
        .then(posts => {
            const postsContainer = document.getElementById('posts');
            postsContainer.innerHTML = ''; // Clear existing posts
            posts.forEach(post => {
                const postElement = document.createElement('div');
                postElement.className = 'posts';
                postElement.innerHTML = `<h3>${post.title}</h3><p>${post.content}</p>`;
                postsContainer.appendChild(postElement);
            });
        })
        .catch(error => console.error('Error loading posts:', error));
}

function createNewPost(form) {
    const formData = new FormData(form);
    fetch('php/create_post.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            document.getElementById('newPostModal').style.display = 'none';
            form.reset();
            loadPosts();
        } else {
            alert('Error creating post');
        }
    })
    .catch(error => console.error('Error creating post:', error));
}
