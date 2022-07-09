const express = require('express');
const axios = require('axios');
const qrcode = require("qrcode-terminal");
const cors = require('cors')
const { Client, MessageMedia, LocalAuth, Location, Buttons} = require("whatsapp-web.js");

const { io } = require("socket.io-client");
const socket = io("https://socket.appxi.net");

const JSONdb = require('simple-json-db');
const { json } = require('express');

require('dotenv').config({ path: '../../.env' })

const app = express();
app.use(cors())
app.use(express.json())


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

client.on("qr", (qr) => {
    qrcode.generate(qr, { small: true });
    console.log('Nuevo QR, recuerde que se genera cada 1/2 minuto.')
});

client.on('ready', async () => {
	app.listen(process.env.CHATBOT_PORT, () => {
		console.log('CHATBOT ESTA LISTO EN EL PUERTO: '+process.env.CHATBOT_PORT);
	});
});

client.on("authenticated", () => {
});

client.on("auth_failure", msg => {
    console.error('AUTHENTICATION FAILURE', msg);

})

client.on('message', async msg => {
    console.log('MESSAGE RECEIVED', msg);
    console.log(msg.type)

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
                list+='\nUsuario encontrado exitosamente\n'
                list+='Credenciales para Ingresar al Sistema:\n'
                list+='Correo: '+miresponse.data.email+' \n'
                list+='Contraseña: '+newpassword+' \n'
                list+='No comparta sus credenciales con nadie.\n'
            }
            else{
                list+='\nNo se encontró un Usuario asociado a este número\n'
                list+='Porfavor contáctese con el administrador del Sistema.\n'
            }
            client.sendMessage(msg.from, list).then((response) => {
                if (response.id.fromMe) {
                    console.log("text fue enviado!");
                }
            })
        break;
        default:
            var list = '*Hola*, soy el 🤖CHATBOT🤖 del : *'+process.env.APP_NAME+'* \n'
            list+='\nIngrese al Sistema para enviar o verificar su documentación correspondiente\n'
            list+='El link es el siguiente: '+process.env.APP_URL+'admin \n'
            list+='Si olvidó su contraseña envíe la palabra: Login\n'
            client.sendMessage(msg.from, list).then((response) => {
                if (response.id.fromMe) {
                    console.log("text fue enviado!");
                }
            })
        break;
    }
})


app.get('/', async (req, res) => {
    res.send('CHATBOT');
});

app.post('/chat', async (req, res) => {
    console.log(req.query.message)
    console.log(req.query.phone)
    var phone_cliente= '591'+req.body.phone+'@c.us'
    client.sendMessage(phone_cliente, req.body.message).then((response) => {
        if (response.id.fromMe) {
            console.log("text fue enviado!");
        }
    })
    res.send('CHATBOT');
});

client.initialize();
