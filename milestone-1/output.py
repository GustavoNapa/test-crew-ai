from flask import Flask, request
import yfinance as yf

app = Flask(__name__)

@app.route('/stock', methods=['GET'])
def get_stock_price():
    stock_symbol = request.args.get('symbol')
    stock = yf.Ticker(stock_symbol)
    stock_info = stock.history(period='1d')
    stock_price = stock_info['Close'].values[0]
    
    return f'The current stock price of {stock_symbol} is ${stock_price}'

if __name__ == '__main__':
    app.run()
