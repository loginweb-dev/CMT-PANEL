const express = require('express');
const axios = require('axios');
const qrcode = require("qrcode-terminal");
const cors = require('cors')
const { Client, MessageMedia, LocalAuth, Location, Buttons} = require("whatsapp-web.js");
var qr = require('qr-image');
var path = require('path');
const { io } = require("socket.io-client");
const socket = io("https://socket.appxi.net");

const JSONdb = require('simple-json-db');

require('dotenv').config({ path: '../../.env' })

const app = express();
app.use(cors())
app.use(express.json())
app.set("view engine", "ejs");
app.use(express.static(path.join(__dirname, 'public')));
app.listen(process.env.CHATBOT_PORT, () => {
    console.log('CHATBOT ESTA LISTO EN EL PUERTO: '+process.env.CHATBOT_PORT);
});

const client = new Client({
    authStrategy: new LocalAuth({
        clientId: "client-one"
    }),
    puppeteer: {
        headless: true,
        ignoreDefaultArgs: ['--disable-extensions'],
        args: ['--no-sandbox']
    }
});

var micount = 0
client.on("qr", (qrwb) => {
    // qrcode.generate(qr, { small: true });
    // console.log('Nuevo QR, recuerde que se genera cada 1/2 minuto.')
    var qr_svg = qr.image(qrwb, { type: 'png' });
    qr_svg.pipe(require('fs').createWriteStream('public/qrwb.png'));
    qrcode.generate(qrwb, {small: true}, function (qrcode) {
        console.log(qrcode)
        console.log('Nuevo QR, recuerde que se genera cada 1 minuto, INTENTO #'+micount++)
        
    })
});

client.on('ready', async () => {
	// app.listen(process.env.CHATBOT_PORT, () => {
		console.log('CHATBOT ESTA LISTO EN EL PUERTO: '+process.env.CHATBOT_PORT);
	// });
});

client.on("authenticated", () => {
});

client.on("auth_failure", msg => {
    console.error('AUTHENTICATION FAILURE', msg);

})

client.on('message', async msg => {
    console.log('MESSAGE RECEIVED', msg);
    let phone=msg.from
    phone=phone.substring(3, 11)
    var newpassword=Math.random().toString().substring(2, 6)
    var midata = {
        phone: phone,
        password: newpassword
    }
    var miresponse= await axios.post(process.env.APP_URL+'api/credenciales', midata)
    switch (true) {
        case (msg.body === 'login') || (msg.body === 'LOGIN')|| (msg.body === 'Login'):
            var list = '*Hola*, soy el 🤖CHATBOT🤖 del : *'+process.env.APP_NAME+'* \n'
            if(miresponse.data){
                list+='Usuario encontrado exitosamente\n'
                list+='Credenciales para Ingresar al Sistema:\n'
                list+='Correo: '+miresponse.data.email+' \n'
                list+='Contraseña: '+newpassword+' \n'
                list+='No comparta sus credenciales con nadie.\n'
                client.sendMessage(msg.from, list)
            }
            else{
                list+='No se encontró un Usuario asociado a este número\n'
                list+='Porfavor contáctese con el administrador del Sistema.\n'
                client.sendMessage(msg.from, list)
                client.sendMessage(msg.from, await client.getContactById(process.env.CHATBOT_ADMIN))
            }            
        break;
        default:
            var list = '*Hola*, soy el 🤖CHATBOT🤖 del : *'+process.env.APP_NAME+'* \n'
            list+='\nIngrese al Sistema para enviar o verificar su documentación correspondiente\n'
            list+='El link es el siguiente: '+process.env.APP_URL+'admin \n'
            list+='Si olvidó su contraseña envíe la palabra: Login\n'
            client.sendMessage(msg.from, list)
        break;
    }
})

app.get('/', async (req, res) => {
    // res.send('CHATBOT');
    res.render('index', {count: micount});
});

app.post('/chat', async (req, res) => {
    var phone_cliente= '591'+req.body.phone+'@c.us'
    client.sendMessage(phone_cliente, req.body.message)
    res.send('CHAT');
});

client.initialize();
