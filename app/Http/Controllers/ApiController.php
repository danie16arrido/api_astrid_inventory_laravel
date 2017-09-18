<?php
namespace App\Http\Controllers;
/**
 * [ApiController description]
 */
class ApiController extends Controller {
  /**
   * [holds Http status code]
   * @var [int]
   */
  protected $statusCode = 200;
  /**
   * [getStatusCode description]
   * @return [int] [description]
   */
  public function getStatusCode()
  {
    return $this->statusCode;
  }
  /**
   * [setStatusCode description]
   * @param [int] $statusCode [description]
   * @return [int]
   */
  public function setStatusCode($statusCode)
  {
    $this->statusCode = $statusCode;
    return $this;
  }
  /**
   * [respondWithInvalidFormat description]
   * @return [Json object] [description]
   */
  public function respondWithInvalidFormat()
  {
    $dataFormatNotValidMessage = 'Data Format not valid';
    return $this->setStatusCode(417)->respondWithError($dataFormatNotValidMessage);
  }
  /**
   * [respondWithInternalError description]
   * @param  string $message [description]
   * @return [Json object]          [description]
   */
  public function respondWithInternalError($message='')
  {
    $internalErrorMessage = ' - Internal Error';
    return $this->setStatusCode(500)->respondWithError($message . $internalErrorMessage);
  }
  /**
   * [respondWithResourceNotFound description]
   * @param  [string] $resourceName [description]
   * @return [Json Object]               [description]
   */
  public function respondWithResourceNotFound($resourceName){
    $notFoundMessage = " not found.";
    return $this->setStatusCode(404)->respondWithError($resourceName . $notFoundMessage);
  }
  /**
   * [respondWithIdNotNumeric description]
   * @return [Json Object] [description]
   */
  public function respondWithIdNotNumeric(){
    $idNotNumericMessage = 'IDs must be numeric.';
    return $this->setStatusCode(417)->respondWithError($idNotNumericMessage);
  }
  /**
   * [respondResourceExists description]
   * @param  [string] $message [description]
   * @return [Json Object]          [description]
   */
  public function respondResourceExists($message){
    $resourceExistsMessage = ' exists.';
    return $this->setStatusCode(422)->respondWithError($message . $resourceExistsMessage);
  }
  /**
   * [respondWithError description]
   * @param  [string] $message [description]
   * @return [Json Object]          [description]
   */
  public function respondWithError($message){
    return response()->json([
        'error' => [
          'message' => $message,
          'status' => 'FAILED'
        ]
      ], $this->getStatusCode() );
  }
  /**
   * [respondAccepted description]
   * @param  [array] $data    [description]
   * @param  [string] $message [description]
   * @return [Json Object]          [description]
   */
  public function respondAccepted($data, $message){
    return $this->setStatusCode(202)->respond($data, $message);
  }
  /**
   * [respondWithResourceCreated description]
   * @param  [array] $data    [description]
   * @param  [string] $resource [description]
   * @return [Json Object]          [description]
   */
  public function respondWithResourceCreated($data, $resource='')
  {
    return $this->setStatusCode(201)->respond($data, $resource . ' created.');
  }
  /**
   * [respond description]
   * @param  [array] $data    [description]
   * @param  [string] $message [description]
   * @return [Json Object]          [description]
   */
  public function respond($data, $message='')
  {
    return response()->json(
      [
        'data' => $data,
        'message' => $message,
        'status' => 'SUCCESS'
      ], $this->getStatusCode()
    );
  }

}
