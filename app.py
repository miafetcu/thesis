from flask import Flask, request, jsonify
import fitz  # PyMuPDF

app = Flask(__name__)

@app.route('/')
def index():
    return app.send_static_file('upload.php')

@app.route('/upload', methods=['POST'])
def upload():
    pdf_file = request.files['pdfFile']

    if pdf_file:
        pdf_data = pdf_file.read()
        pdf_document = fitz.open("pdf_file",pdf_data)
        consumption = pdf_document.pq('LTTextLineHorizontal:in_bbox("419.0, 599.85, 430.676, 606.85")').text()
        initial_date = pdf_document.pq('LTTextLineHorizontal:in_bbox("290.0, 725.85, 317.23, 732.85")').text()

        result = {
            'consumption': consumption,
            'initial_date': initial_date
        }

        return jsonify(result)
    else:
        return jsonify({'error': 'No PDF file uploaded'})

if __name__ == '__main__':
    app.run(debug=True)
