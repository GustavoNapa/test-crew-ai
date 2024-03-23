from fastapi import FastAPI, HTTPException
from pydantic import BaseModel
import requests

class PixChargeRequest(BaseModel):
    amount: float
    payer_payee_id: str
    method: str = 'PIX'

class PixChargeStatusRequest(BaseModel):
    transaction_id: str

class PixWithdrawalRequest(BaseModel):
    amount: float
    payee_id: str

class PixWithdrawalStatusRequest(BaseModel):
    withdrawal_id: str

app = FastAPI()

@app.post('/create_pix_charge')
def create_pix_charge(request: PixChargeRequest):
    # Here you would integrate with the PIX API to create a charge
    pass

@app.get('/check_pix_charge_status/{transaction_id}')
def check_pix_charge_status(request: PixChargeStatusRequest):
    # Here you would integrate with the PIX API to check the status of a charge
    pass

@app.post('/create_pix_withdrawal')
def create_pix_withdrawal(request: PixWithdrawalRequest):
    # Here you would integrate with the PIX API to create a withdrawal transaction
    pass

@app.get('/check_pix_withdrawal_status/{withdrawal_id}')
def check_pix_withdrawal_status(request: PixWithdrawalStatusRequest):
    # Here you would integrate with the PIX API to check the status of a withdrawal
    pass