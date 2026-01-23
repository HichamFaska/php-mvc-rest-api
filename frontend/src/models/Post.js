import { ENDPOINT } from "../env.js";

class Post{
    constructor(user,title,content){
        this.user = user
        this.title = title
        this.content = content
    }

    static getAll = async () => {
        try{
            const response = await fetch(`${ENDPOINT.API_URL}`);
            const data = await response.json()
            if(!response.ok){
                throw new Error(`${response.status} ${response.statusText}`)
            }
            if(!data.success){
                throw new Error(data.message)
            }
            return data
        }
        catch(error){
            return {
                "success" : false,
                "message" : error.message
            }
        }
    }

    static add = async (userID,title,content) => {
        try{
            const response = await fetch(`${ENDPOINT.API_URL}`, {
                method: "POST",
                headers : {
                    "Content-Type" : "application/json"
                },
                body: JSON.stringify({
                    "user_id" : userID,
                    "title" : title,
                    "content" : content
                })
            })

            if(!response.ok){
                throw new Error(`${response.status} ${response.statusText}`)
            }

            const data = await response.json()
            if(!data.success){
                throw new Error(data.message)
            }
            return data
        }
        catch(error){
            return {
                "success" : false,
                "message" : error.message
            }
        }
    }
}

export default Post