from fastapi import FastAPI

app = FastAPI()

@app.post("/query")
async def create_item(query: str):
    with open("query.log", "a") as f:
        f.write(query + "\n")

    return True