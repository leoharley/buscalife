const chatInput = document.querySelector("#chat-input");
const sendButton = document.querySelector("#send-btn");
const chatContainer = document.querySelector(".chat-container");
const themeButton = document.querySelector("#theme-btn");
const deleteButton = document.querySelector("#delete-btn");

let userText = null;
const API_KEY = "sk-proj-g0fbWvQueDXxUgL3H4tHT3BlbkFJogxy6lh0H79jeHbba5dZ"; // Paste your API key here

const loadDataFromLocalstorage = () => {
    // Load saved chats and theme from local storage and apply/add on the page
    const themeColor = localStorage.getItem("themeColor");

    document.body.classList.toggle("light-mode", themeColor === "light_mode");
    themeButton.innerText = document.body.classList.contains("light-mode") ? "dark_mode" : "light_mode";

    const defaultText = `<div class="default-text">
                           <img src="img/logo.png" width="46vh" height=auto><span class="titulo_texto">Busca Quem Faz</span>
                           <!-- <p>Inteligência artificial que analisa milhares de profissionais verificados<br/>e seleciona os mais qualificados e disponíveis para atender você.</p> -->
                           <p>Inteligência Artificial de verificação e indicação de profissionais,<br/>mostra o grau de recomendação, valor do serviço e disponibilidade.</p>
                           <!-- <p>Inteligência artificial que analisa em detalhes o serviço que você precisa e<br/>mostra os profissionais mais indicados com valores e disponibilidades.</p> -->
                            <br/>
                            <img src="images/banner.png" class="banner">
                        </div>`

    document.getElementsByName('chat-input')[0].placeholder='Me diz que serviço está precisando?';                     

    /*const defaultText2 = `<div class="chat incoming"><div class="chat-content">
                    <div class="chat-details">
                        <img src="images/chatbot.jpg" alt="chatbot-img">
                        
                    <p>GAEL e ROYCE</p></div>
                    <span onclick="copyResponse(this)" class="material-symbols-rounded">content_copy</span>
                </div></div>`*/

    chatContainer.innerHTML = localStorage.getItem("all-chats") || defaultText;
    chatContainer.scrollTo(0, chatContainer.scrollHeight); // Scroll to bottom of the chat container
}

const createChatElement = (content, className) => {
    // Create new div and apply chat, specified class and set html content of div
    const chatDiv = document.createElement("div");
    chatDiv.classList.add("chat", className);    
    chatDiv.innerHTML = content;
    document.getElementsByName('chat-input')[0].placeholder='Digite aqui a sua mensagem';    
    return chatDiv; // Return the created chat div
}

const getChatResponse = async (incomingChatDiv) => {
    const API_URL = "http://localhost/bqf-api/chatbot";
    const pElement = document.createElement("p");

    const formData = new FormData();
    formData.append('requestText', userText);

    // Define the properties and data for the API request
    const requestOptions = {
        method: 'POST',
        body: formData
    }

    // Send POST request to API, get response and set the reponse as paragraph element text
    try {
        const response = await (await fetch(API_URL, requestOptions)).json();        
        pElement.textContent = response.responseText.trim();
    } catch (error) { // Add error class to the paragraph element and set error text
        pElement.classList.add("error");
        pElement.textContent = "Oops! Something went wrong while retrieving the response. Please try again.";
    }

    // Remove the typing animation, append the paragraph element and save the chats to local storage
    incomingChatDiv.querySelector(".typing-animation").remove();
    incomingChatDiv.querySelector(".chat-details").appendChild(pElement);
    localStorage.setItem("all-chats", chatContainer.innerHTML);
    chatContainer.scrollTo(0, chatContainer.scrollHeight);
}

const copyResponse = (copyBtn) => {
    // Copy the text content of the response to the clipboard
    const reponseTextElement = copyBtn.parentElement.querySelector("p");
    navigator.clipboard.writeText(reponseTextElement.textContent);
    copyBtn.textContent = "done";
    setTimeout(() => copyBtn.textContent = "content_copy", 1000);
}

const showTypingAnimation = () => {
    // Display the typing animation and call the getChatResponse function
    const html = `<div class="chat-content">
                    <div class="chat-details">
                        <img src="images/chatbot.jpg" alt="chatbot-img">
                        <div class="typing-animation">
                            <div class="typing-dot" style="--delay: 0.2s"></div>
                            <div class="typing-dot" style="--delay: 0.3s"></div>
                            <div class="typing-dot" style="--delay: 0.4s"></div>
                        </div>
                    </div>
                    <span onclick="copyResponse(this)" class="material-symbols-rounded">content_copy</span>
                </div>`;
    // Create an incoming chat div with typing animation and append it to chat container
    const incomingChatDiv = createChatElement(html, "incoming");
    chatContainer.appendChild(incomingChatDiv);
    chatContainer.scrollTo(0, chatContainer.scrollHeight);
    getChatResponse(incomingChatDiv);
}

const handleOutgoingChat = () => {
    userText = chatInput.value.trim(); // Get chatInput value and remove extra spaces
    if(!userText) return; // If chatInput is empty return from here

    // Clear the input field and reset its height
    chatInput.value = "";
    chatInput.style.height = `${initialInputHeight}px`;

    const html = `<div class="chat-content">
                    <div class="chat-details">
                        <img src="images/user.jpg" alt="user-img">
                        <p>${userText}</p>
                    </div>
                </div>`;

    // Create an outgoing chat div with user's message and append it to chat container
    const outgoingChatDiv = createChatElement(html, "outgoing");
    chatContainer.querySelector(".default-text")?.remove();
    chatContainer.appendChild(outgoingChatDiv);
    chatContainer.scrollTo(0, chatContainer.scrollHeight);
    setTimeout(showTypingAnimation, 500);
}

deleteButton.addEventListener("click", () => {
    // Remove the chats from local storage and call loadDataFromLocalstorage function
    if(confirm("Are you sure you want to delete all the chats?")) {
        localStorage.removeItem("all-chats");
        loadDataFromLocalstorage();
    }
});

const new_conversation = async () => {
    if(confirm("Are you sure you want to delete all the chats?")) {
        localStorage.removeItem("all-chats");
        loadDataFromLocalstorage();
    }
}


var modal_termos_de_uso = document.getElementById("modal_termos_de_uso");
var modal_politica_de_privacidade = document.getElementById("modal_politica_de_privacidade");
var modal_faq = document.getElementById("modal_faq");

// Get the button that opens the modal
var btn_termos_de_uso = document.getElementById("termos_uso");
var btn_termos_de_uso_2 = document.getElementById("termos_uso_2");
var btn_politica_de_privacidade = document.getElementById("politica_privacidade");
var btn_politica_de_privacidade_2 = document.getElementById("politica_privacidade_2");
var btn_faq = document.getElementById("faq");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];
var span2 = document.getElementsByClassName("close2")[0];
var span3 = document.getElementsByClassName("close3")[0];

// When the user clicks the button, open the modal 
btn_termos_de_uso.onclick = function() {
    modal_termos_de_uso.style.display = "none";
    modal_politica_de_privacidade.style.display = "none";
    modal_faq.style.display = "none";

    modal_termos_de_uso.style.display = "block";
}

btn_termos_de_uso_2.onclick = function() {
    modal_termos_de_uso.style.display = "none";
    modal_politica_de_privacidade.style.display = "none";
    modal_faq.style.display = "none";

    modal_termos_de_uso.style.display = "block";
}

btn_politica_de_privacidade.onclick = function() {
    modal_termos_de_uso.style.display = "none";
    modal_politica_de_privacidade.style.display = "none";
    modal_faq.style.display = "none";

    modal_politica_de_privacidade.style.display = "block";
}

btn_politica_de_privacidade_2.onclick = function() {
    modal_termos_de_uso.style.display = "none";
    modal_politica_de_privacidade.style.display = "none";
    modal_faq.style.display = "none";

    modal_politica_de_privacidade.style.display = "block";
}

btn_faq.onclick = function() {
    modal_termos_de_uso.style.display = "none";
    modal_politica_de_privacidade.style.display = "none";
    modal_faq.style.display = "none";

    modal_faq.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal_termos_de_uso.style.display = "none";
    modal_politica_de_privacidade.style.display = "none";
}

span2.onclick = function() {
    modal_politica_de_privacidade.style.display = "none";
}

span3.onclick = function() {
    modal_faq.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal_termos_de_uso||
    event.target == modal_politica_de_privacidade||
    event.target == modal_faq) {
    modal_termos_de_uso.style.display = "none";
    modal_politica_de_privacidade.style.display = "none";
    modal_faq.style.display = "none";
  }
}


themeButton.addEventListener("click", () => {
    // Toggle body's class for the theme mode and save the updated theme to the local storage 
    document.body.classList.toggle("light-mode");
    localStorage.setItem("themeColor", themeButton.innerText);
    themeButton.innerText = document.body.classList.contains("light-mode") ? "dark_mode" : "light_mode";
});

const initialInputHeight = chatInput.scrollHeight;

chatInput.addEventListener("input", () => {   
    // Adjust the height of the input field dynamically based on its content
    chatInput.style.height =  `${initialInputHeight}px`;
    chatInput.style.height = `${chatInput.scrollHeight}px`;
});

chatInput.addEventListener("keydown", (e) => {
    // If the Enter key is pressed without Shift and the window width is larger 
    // than 800 pixels, handle the outgoing chat
    if (e.key === "Enter" && !e.shiftKey && window.innerWidth > 800) {
        e.preventDefault();
        handleOutgoingChat();
    }
});

const go_login = async () => {
    redirect("login/login.php");
}

const go_register = async () => {
    redirect("login/cadastro.php");
}

function redirect (url) {
    var ua        = navigator.userAgent.toLowerCase(),
        isIE      = ua.indexOf('msie') !== -1,
        version   = parseInt(ua.substr(4, 2), 10);

    // Internet Explorer 8 and lower
    if (isIE && version < 9) {
        var link = document.createElement('a');
        link.href = url;
        document.body.appendChild(link);
        link.click();
    }

    // All other browsers can use the standard window.location.href (they don't lose HTTP_REFERER like Internet Explorer 8 & lower does)
    else { 
        window.location.href = url; 
    }
}

document.querySelector(".mobile-sidebar").addEventListener("click", (event) => {
    const sidebar = document.querySelector(".conversations");
  
    if (sidebar.classList.contains("shown")) {
      sidebar.classList.remove("shown");
      event.target.classList.remove("rotated");
    } else {
      sidebar.classList.add("shown");
      event.target.classList.add("rotated");
    }
  
    window.scrollTo(0, 0);
  });

loadDataFromLocalstorage();
sendButton.addEventListener("click", handleOutgoingChat);