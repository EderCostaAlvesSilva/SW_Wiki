FROM node:14.16.1

WORKDIR /L5_Networks/documentation

USER root

RUN npm i -g insomnia-documenter && npm install pm2 -g

COPY ./documentation/Insomnia_2025-01-20.json ./  

CMD ["sh", "-c", "npx insomnia-documenter --config Insomnia_2025-01-20.json && npx insomnia-documenter --config Insomnia_2025-01-20.json --output insomnia-documenter-demo && npx serve"]
